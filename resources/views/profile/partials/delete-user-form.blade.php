<div>
    <h2 class="text-lg font-bold text-gray-900">Hapus Akun</h2>
    <p class="text-sm text-gray-500 mt-1">Setelah akun dihapus, semua data akan dihapus secara permanen. Harap backup data penting Anda sebelum melanjutkan.</p>
</div>

<div class="mt-4">
    <button type="button" onclick="document.getElementById('confirm-delete-modal').classList.remove('hidden')"
        class="px-6 py-3 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 transition-all shadow-lg shadow-red-100">
        Hapus Akun
    </button>
</div>

<div id="confirm-delete-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Yakin ingin menghapus akun?</h3>
        <p class="text-sm text-gray-500 mb-6">Setelah akun dihapus, semua data akan dihapus secara permanen. Masukkan kata sandi Anda untuk konfirmasi.</p>
        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')
            <div class="mb-4">
                <input id="password" name="password" type="password"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-1 focus:ring-red-500 outline-none transition-all text-sm"
                    placeholder="Masukkan kata sandi">
                @error('password', 'userDeletion')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex items-center justify-end gap-3">
                <button type="button" onclick="document.getElementById('confirm-delete-modal').classList.add('hidden')"
                    class="px-4 py-2.5 text-sm text-gray-600 hover:underline font-medium">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2.5 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 transition-all">
                    Hapus Akun
                </button>
            </div>
        </form>
    </div>
</div>
