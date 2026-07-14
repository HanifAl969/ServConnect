@extends('layouts.admin')

@section('title', 'Tambah User — ServeConnect')

@section('header', 'Tambah User Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="p-8">
            <header class="mb-6">
                <p class="text-sm text-gray-500">Buat akun baru untuk Admin, Vendor, atau User biasa.</p>
            </header>

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="text-sm font-bold text-gray-700 block mb-1" for="name">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm" placeholder="Masukkan nama lengkap"/>
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-bold text-gray-700 block mb-1" for="email">Alamat Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm" placeholder="nama@email.com"/>
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-bold text-gray-700 block mb-1" for="role">Role / Hak Akses</label>
                    <select id="role" name="role"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm">
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User (Pembeli)</option>
                        <option value="vendor" {{ old('role') == 'vendor' ? 'selected' : '' }}>Vendor (Penyedia Jasa)</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengelola)</option>
                    </select>
                    @error('role') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-bold text-gray-700 block mb-1" for="password">Password</label>
                    <input id="password" name="password" type="password" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm" placeholder="Minimal 8 karakter"/>
                    <p class="text-[10px] text-gray-400 mt-1">*Minimal 8 karakter</p>
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-[#003fb1] text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-100 hover:opacity-90 transition-all">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
