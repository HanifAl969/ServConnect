<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function create(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized.');
        }

        if ($booking->status !== 'accepted') {
            return redirect()->back()->with('error', 'Booking harus diterima vendor terlebih dahulu.');
        }

        if ($booking->payment && $booking->payment->status === 'success') {
            return redirect()->back()->with('error', 'Pembayaran sudah dilakukan.');
        }

        return view('payment.create', compact('booking'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        if ($booking->user_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized.');
        }

        if ($booking->status !== 'accepted') {
            return back()->with('error', 'Booking harus diterima vendor terlebih dahulu.');
        }

        if ($booking->payment) {
            return back()->with('error', 'Pembayaran sudah diajukan.');
        }

        $proofPath = $request->file('payment_proof')->store('payments', 'public');

        DB::transaction(function () use ($booking, $proofPath) {
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $booking->jasa->harga,
                'status' => 'pending',
                'payment_method' => 'transfer',
                'transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
                'payment_proof' => $proofPath,
            ]);
        });

        return redirect()->route('bookings.index')
            ->with('success', 'Bukti pembayaran berhasil diunggah! Tunggu konfirmasi dari penyedia jasa.');
    }
}
