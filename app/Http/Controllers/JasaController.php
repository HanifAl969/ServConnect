<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JasaController extends Controller
{

    public function index()
    {
        $jasas = Jasa::where('user_id', \Illuminate\Support\Facades\Auth::id())->latest()->get();

        return view('vendor.dashboard', compact('jasas'));
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
            'gambar'    => 'required|image|mimes:jpeg,jpg,png|max:2048', 
        ]);

        $namaGambar = null;
        if ($request->hasFile('gambar')) {
            $file       = $request->file('gambar');
            $namaGambar = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('storage/jasa'), $namaGambar);
        }
        Jasa::create([
            'user_id'   => Auth::id(),
            'kategori'  => $request->kategori,
            'nama_jasa' => $request->nama_jasa,
            'harga'     => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar'    => $namaGambar,
        ]);

        return redirect()->route('dashboard')->with('success', 'Layanan jasa baru berhasil diterbitkan!');
    }
}
