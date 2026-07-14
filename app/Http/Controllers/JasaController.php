<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jasa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JasaController extends Controller
{

    public function index()
    {
        $userId = Auth::id();

        $jasas = Jasa::where('user_id', $userId)
            ->withCount(['bookings as completed_count' => fn($q) => $q->where('status', 'completed')->whereHas('payment', fn($q) => $q->where('status', 'success'))])
            ->latest()
            ->get();

        $pendingBookings = \App\Models\Booking::where('vendor_id', $userId)->where('status', 'pending')->count();
        $acceptedBookings = \App\Models\Booking::where('vendor_id', $userId)->where('status', 'accepted')->count();
        $completedBookings = \App\Models\Booking::where('vendor_id', $userId)->where('status', 'completed')->count();
        $totalRevenue = \App\Models\Booking::where('vendor_id', $userId)->where('status', 'completed')
            ->whereHas('payment', fn($q) => $q->where('status', 'success'))
            ->with('jasa')
            ->get()
            ->sum(fn($b) => $b->jasa->harga);
        $totalViews = Jasa::where('user_id', $userId)->sum('views');

        return view('vendor.dashboard', compact('jasas', 'pendingBookings', 'acceptedBookings', 'completedBookings', 'totalRevenue', 'totalViews'));
    }

    public function create()
    {
        return view('vendor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jasa' => 'required|string|max:255',
            'kategori'  => 'required|string|max:255',
            'harga'     => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'gambar'    => 'required|array|min:3',
            'gambar.*'  => 'image|mimes:jpeg,jpg,png|max:5120',
        ]);

        $namaGambar = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/jasa'), $filename);
                $namaGambar[] = $filename;
            }
        }

        Jasa::create([
            'user_id'   => Auth::id(),
            'kategori'  => $request->kategori,
            'nama_jasa' => $request->nama_jasa,
            'harga'     => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $namaGambar,
        ]);

        return redirect()->route('dashboard')->with('success', 'Data Jasa Berhasil Disimpan');
    }

    public function show(Jasa $jasa)
    {
        $jasa->increment('views');

        $agents = User::where('role', 'vendor')
            ->where('status', 'active')
            ->whereHas('jasas', fn($q) => $q->where('kategori', $jasa->kategori))
            ->with(['jasas' => fn($q) => $q->where('kategori', $jasa->kategori)->select('id', 'user_id', 'nama_jasa', 'deskripsi')])
            ->withCount([
                'jasas' => fn($q) => $q->where('kategori', $jasa->kategori),
                'vendorBookings as bookings_accepted_count' => fn($q) => $q->whereIn('status', ['accepted', 'completed']),
            ])
            ->get();

        return view('jasa.show', compact('jasa', 'agents'));
    }

    public function edit(Jasa $jasa)
    {
        if ($jasa->user_id !== Auth::id()) {
            abort(403);
        }

        return view('vendor.edit', compact('jasa'));
    }

    public function update(Request $request, Jasa $jasa)
    {
        if ($jasa->user_id !== Auth::id()) {
            abort(403);
        }

        $rules = [
            'nama_jasa' => 'required|string|max:255',
            'kategori'  => 'required|string|max:255',
            'harga'     => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
        ];

        if ($request->hasFile('gambar')) {
            $rules['gambar']   = 'required|array|min:3';
            $rules['gambar.*'] = 'image|mimes:jpeg,jpg,png|max:5120';
        }

        $request->validate($rules);

        $data = $request->only(['nama_jasa', 'kategori', 'harga', 'deskripsi']);

        if ($request->hasFile('gambar')) {
            foreach ($jasa->gambar ?? [] as $oldImage) {
                $path = public_path('storage/jasa/' . $oldImage);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $namaGambar = [];
            foreach ($request->file('gambar') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/jasa'), $filename);
                $namaGambar[] = $filename;
            }
            $data['gambar'] = $namaGambar;
        }

        $jasa->update($data);

        return redirect()->route('dashboard')->with('success', 'Data Jasa Berhasil Diperbarui');
    }

    public function destroy(Jasa $jasa)
    {
        if ($jasa->user_id !== Auth::id()) {
            abort(403);
        }

        foreach ($jasa->gambar ?? [] as $oldImage) {
            $path = public_path('storage/jasa/' . $oldImage);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $jasa->delete();

        return redirect()->route('dashboard')->with('success', 'Data Jasa Berhasil Dihapus');
    }
}
