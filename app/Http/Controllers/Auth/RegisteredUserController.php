<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\VendorCertificate;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:user,vendor'],
            'ktp_photo' => ['required_if:role,user', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'vendor_type' => ['required_if:role,vendor', 'in:umkm,enterprise'],
            'certificates' => ['required_if:role,vendor', 'array', 'min:1'],
            'certificates.*' => ['image', 'mimes:jpg,jpeg,png', 'max:5120'],
        ];

        $request->validate($rules);

        $role = $request->role;
        $status = 'pending';

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'status' => $status,
            'email_verified_at' => now(),
        ];

        if ($role === 'user') {
            $userData['ktp_photo'] = $request->file('ktp_photo')->store('ktp', 'public');
        }

        if ($role === 'vendor') {
            $userData['vendor_type'] = $request->vendor_type;
        }

        $user = User::create($userData);

        if ($role === 'vendor' && $request->hasFile('certificates')) {
            foreach ($request->file('certificates') as $file) {
                VendorCertificate::create([
                    'user_id' => $user->id,
                    'certificate_file' => $file->store('certificates', 'public'),
                    'certificate_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        $message = $role === 'vendor'
            ? 'Akun vendor berhasil didaftarkan! Silakan tunggu verifikasi dari admin.'
            : 'Akun berhasil didaftarkan! Silakan tunggu verifikasi KTP oleh admin.';

        return redirect()->route('login')->with('success', $message);
    }
}
