<div>
    <h2 class="text-lg font-bold text-gray-900">Perbarui Kata Sandi</h2>
    <p class="text-sm text-gray-500 mt-1">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak untuk keamanan.</p>
</div>

<form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-5">
    @csrf
    @method('put')

    <div>
        <label for="update_password_current_password" class="block text-sm font-bold text-gray-700 mb-1">Kata Sandi Saat Ini</label>
        <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm">
        @error('current_password', 'updatePassword')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="update_password_password" class="block text-sm font-bold text-gray-700 mb-1">Kata Sandi Baru</label>
        <input id="update_password_password" name="password" type="password" autocomplete="new-password"
            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm">
        @error('password', 'updatePassword')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="update_password_password_confirmation" class="block text-sm font-bold text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
        <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm">
        @error('password_confirmation', 'updatePassword')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-4 pt-2">
        <button type="submit" class="px-6 py-3 bg-[#003fb1] text-white rounded-xl text-sm font-bold hover:opacity-90 transition-all shadow-lg shadow-blue-100">
            Simpan
        </button>
        @if (session('status') === 'password-updated')
            <p class="text-sm text-green-600 font-medium">Tersimpan.</p>
        @endif
    </div>
</form>
