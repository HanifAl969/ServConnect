@extends('layouts.vendor')

@section('title', 'Edit Jasa — ServeConnect')

@section('header', 'Edit Jasa')
@section('subheader', 'Perbarui informasi jasa yang Anda tawarkan')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50">
            <h2 class="text-xl font-bold text-gray-900">Informasi Jasa</h2>
            <p class="text-xs text-gray-500 font-medium mt-1">Edit detail jasa Anda di bawah ini.</p>
        </div>

        <div class="p-8">
            <form action="{{ route('vendor.jasa.update', $jasa) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="nama_jasa" class="block text-sm font-bold text-gray-700 mb-1">Nama Jasa</label>
                    <input id="nama_jasa" name="nama_jasa" type="text" value="{{ old('nama_jasa', $jasa->nama_jasa) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm"
                        placeholder="Contoh: Jasa Cuci AC Bergaransi" required>
                    @error('nama_jasa')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="kategori" class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                        <select id="kategori" name="kategori"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm">
                            <option value="">Pilih Kategori</option>
                            <option value="Cleaning" {{ old('kategori', $jasa->kategori) == 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                            <option value="Repair" {{ old('kategori', $jasa->kategori) == 'Repair' ? 'selected' : '' }}>Repair</option>
                            <option value="Creative" {{ old('kategori', $jasa->kategori) == 'Creative' ? 'selected' : '' }}>Creative</option>
                            <option value="Business" {{ old('kategori', $jasa->kategori) == 'Business' ? 'selected' : '' }}>Business</option>
                        </select>
                        @error('kategori')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="harga" class="block text-sm font-bold text-gray-700 mb-1">Harga (Rp)</label>
                        <input id="harga" name="harga" type="number" value="{{ old('harga', $jasa->harga) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm"
                            placeholder="Contoh: 150000" required>
                        @error('harga')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="deskripsi" class="block text-sm font-bold text-gray-700 mb-1">Deskripsi Jasa</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm"
                        placeholder="Jelaskan detail layanan Anda...">{{ old('deskripsi', $jasa->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Foto Jasa Saat Ini</label>
                    <div class="flex gap-3 flex-wrap mb-4">
                        @foreach ($jasa->gambar ?? [] as $img)
                            <div class="w-24 h-24 rounded-xl border border-gray-200 overflow-hidden">
                                <img src="{{ asset('storage/jasa/' . $img) }}"
                                    class="w-full h-full object-cover"
                                    onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Foto&background=003fb1&color=fff';">
                            </div>
                        @endforeach
                    </div>

                    <label class="block text-sm font-bold text-gray-700 mb-1">Ganti Foto (Opsional)</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="gambar" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <span class="material-symbols-outlined text-gray-400 mb-2">cloud_upload</span>
                                <p class="text-xs text-gray-500">Upload 3 foto baru untuk mengganti foto existing</p>
                                <p class="text-xs text-gray-400 mt-1">PNG, JPG atau JPEG (Maks. 5MB/file)</p>
                            </div>
                            <input id="gambar" name="gambar[]" type="file" class="hidden" accept="image/*" multiple />
                        </label>
                    </div>
                    @error('gambar')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    @error('gambar.*')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-400 mt-2" id="file-count">Kosongkan jika tidak ingin mengganti foto</p>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:underline font-medium">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-[#003fb1] text-white rounded-xl text-sm font-bold hover:opacity-90 transition-all shadow-lg shadow-blue-100">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

            <form action="{{ route('vendor.jasa.destroy', $jasa) }}" method="POST" class="mt-8 pt-6 border-t border-gray-100" onsubmit="return confirm('Yakin ingin menghapus jasa ini? Tindakan ini tidak dapat dibatalkan.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm font-bold text-red-500 hover:text-red-700 transition">
                    Hapus Jasa
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('gambar').addEventListener('change', function() {
    const count = this.files.length;
    document.getElementById('file-count').textContent = count + ' file dipilih' + (count > 0 && count < 3 ? ' (min. 3 untuk mengganti)' : '');
});
</script>
@endsection
