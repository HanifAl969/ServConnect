<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VendorCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function talent()
    {
        $vendor = Auth::user()->load('certificates');
        $agents = User::where('role', 'vendor')
            ->where('status', 'active')
            ->with('certificates')
            ->withCount('jasas')
            ->latest()
            ->get();

        return view('vendor.talent', compact('vendor', 'agents'));
    }

    public function uploadCertificate(Request $request)
    {
        $request->validate([
            'certificate' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'certificate_name' => ['nullable', 'string', 'max:255'],
        ]);

        VendorCertificate::create([
            'user_id' => Auth::id(),
            'certificate_file' => $request->file('certificate')->store('certificates', 'public'),
            'certificate_name' => $request->input('certificate_name'),
        ]);

        return redirect()->route('vendor.talent')
            ->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function deleteCertificate(VendorCertificate $certificate)
    {
        if ($certificate->user_id !== Auth::id()) {
            return back()->with('error', 'Sertifikat bukan milik Anda.');
        }

        $certificate->delete();

        return redirect()->route('vendor.talent')
            ->with('success', 'Sertifikat berhasil dihapus.');
    }
}
