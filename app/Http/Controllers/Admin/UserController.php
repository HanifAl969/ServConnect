<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\AccountVerified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function vendorVerification()
    {
        $vendors = User::where('role', 'vendor')
            ->with('certificates')
            ->latest()
            ->paginate(10);
        return view('admin.users.vendor-verification', compact('vendors'));
    }

    public function approveVendor(User $user)
    {
        if ($user->role !== 'vendor') {
            return back()->with('error', 'User bukan vendor.');
        }

        $user->update(['status' => 'active']);
        $user->notify(new AccountVerified("Selamat! Akun vendor Anda telah disetujui. Anda sekarang dapat menawarkan jasa di ServeConnect."));

        return redirect()->route('admin.vendor.verification')
            ->with('success', "Vendor {$user->name} berhasil diverifikasi!");
    }

    public function rejectVendor(User $user)
    {
        if ($user->role !== 'vendor') {
            return back()->with('error', 'User bukan vendor.');
        }

        $user->update(['status' => 'rejected']);

        return redirect()->route('admin.vendor.verification')
            ->with('success', "Vendor {$user->name} ditolak.");
    }

    public function userVerification()
    {
        $users = User::where('role', 'user')->latest()->paginate(10);
        return view('admin.users.user-verification', compact('users'));
    }

    public function approveUser(User $user)
    {
        if ($user->role !== 'user') {
            return back()->with('error', 'User bukan role user.');
        }

        $user->update(['status' => 'active']);
        $user->notify(new AccountVerified("Selamat! KTP Anda telah diverifikasi. Anda sekarang dapat memesan jasa di ServeConnect."));

        return redirect()->route('admin.user.verification')
            ->with('success', "User {$user->name} berhasil diverifikasi!");
    }

    public function rejectUser(User $user)
    {
        if ($user->role !== 'user') {
            return back()->with('error', 'User bukan role user.');
        }

        $user->update(['status' => 'rejected']);

        return redirect()->route('admin.user.verification')
            ->with('success', "User {$user->name} ditolak.");
    }

    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,vendor,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'role' => 'required|in:admin,vendor,user',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Nggak bisa hapus akun sendiri, Bang!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}