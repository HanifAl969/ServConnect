<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Jasa;
use App\Models\User;
use App\Http\Requests\BookingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\BookingCreated;
use App\Notifications\BookingStatusChanged;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['jasa', 'vendor', 'payment'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('booking.index', compact('bookings'));
    }

    public function create(Jasa $jasa, ?User $vendor = null)
    {
        if (Auth::user()->status !== 'active') {
            return redirect()->route('dashboard')
                ->with('error', 'Akun Anda masih menunggu verifikasi KTP oleh admin.');
        }

        if ($vendor && $vendor->id !== Auth::id()) {
            if ($jasa->user_id === Auth::id()) {
                return redirect()->back()->with('error', 'Tidak bisa booking jasa milik sendiri.');
            }
        }

        $agents = User::where('role', 'vendor')->where('status', 'active')
            ->whereHas('jasas', fn($q) => $q->where('kategori', $jasa->kategori))
            ->withCount([
                'jasas',
                'vendorBookings as bookings_accepted_count' => fn($q) => $q->whereIn('status', ['accepted', 'completed']),
            ])
            ->get();

        return view('booking.create', compact('jasa', 'vendor', 'agents'));
    }

    public function store(BookingRequest $request)
    {
        if (Auth::user()->status !== 'active') {
            return redirect()->route('dashboard')
                ->with('error', 'Akun Anda masih menunggu verifikasi KTP oleh admin.');
        }

        $validated = $request->validated();

        $jasa = Jasa::findOrFail($validated['jasa_id']);

        if ($jasa->user_id === Auth::id()) {
            return back()->with('error', 'Tidak bisa booking jasa milik sendiri.');
        }

        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photos[] = $photo->store('bookings', 'public');
            }
        }

        $booking = DB::transaction(function () use ($validated, $jasa, $photos) {
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'jasa_id' => $jasa->id,
                'vendor_id' => $validated['vendor_id'],
                'status' => 'pending',
                'booking_date' => $validated['booking_date'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'preferred_time' => $validated['preferred_time'] ?? null,
                'photos' => $photos,
                'notes' => $validated['notes'] ?? null,
            ]);

            $booking->vendor->notify(new BookingCreated($booking));

            return $booking;
        });

        return redirect()->route('bookings.index')
            ->with('success', 'Booking berhasil dibuat! Tunggu konfirmasi dari penyedia jasa.');
    }

    public function confirmPayment(Booking $booking)
    {
        if ($booking->vendor_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $payment = $booking->payment;

        if (!$payment || $payment->status !== 'pending') {
            return back()->with('error', 'Tidak ada pembayaran yang perlu dikonfirmasi.');
        }

        DB::transaction(function () use ($booking, $payment) {
            $payment->update([
                'status' => 'success',
                'paid_at' => now(),
                'confirmed_at' => now(),
            ]);

            $booking->update(['status' => 'completed']);
        });

        return redirect()->route('vendor.bookings')
            ->with('success', 'Pembayaran dikonfirmasi! Booking selesai.');
    }

    public function adminIndex()
    {
        $bookings = Booking::with(['user', 'vendor', 'jasa', 'payment'])
            ->latest()
            ->paginate(15);

        return view('admin.bookings', compact('bookings'));
    }

    public function vendorIndex()
    {
        $bookings = Booking::with(['user', 'jasa', 'payment'])
            ->where('vendor_id', Auth::id())
            ->latest()
            ->get();

        return view('vendor.bookings', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        if ($booking->vendor_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        $validated = $request->validate([
            'status' => 'required|in:accepted,cancelled',
        ]);

        $booking = DB::transaction(function () use ($booking, $validated) {
            $booking->update(['status' => $validated['status']]);

            $booking->user->notify(new BookingStatusChanged($booking));

            return $booking;
        });

        $message = $validated['status'] === 'accepted'
            ? 'Booking diterima! Silakan hubungi pelanggan.'
            : 'Booking ditolak.';

        return redirect()->route('vendor.bookings')->with('success', $message);
    }
}
