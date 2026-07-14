@extends('layouts.admin')

@section('title', 'Edit User — ServeConnect')

@section('header', 'Edit Akun: ' . $user->name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="p-8">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-bold text-gray-700 block mb-1" for="name">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ $user->name }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm"/>
                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-bold text-gray-700 block mb-1" for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ $user->email }}" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm"/>
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-sm font-bold text-gray-700 block mb-1" for="role">Role</label>
                    <select name="role"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="vendor" {{ $user->role == 'vendor' ? 'selected' : '' }}>Vendor</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div class="p-4 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    <label class="text-sm font-bold text-gray-700 block mb-1" for="password">Ganti Password <span class="text-gray-400 font-normal">(Opsional)</span></label>
                    <input id="password" name="password" type="password"
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm" placeholder="Isi hanya jika ingin ganti password"/>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-[#003fb1] text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-100 hover:opacity-90 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
