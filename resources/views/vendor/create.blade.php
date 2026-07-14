@extends('layouts.vendor')

@section('title', 'Tambah Jasa — ServeConnect')

@section('header', 'Tambah Jasa Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50">
            <h2 class="text-xl font-bold text-gray-900">Informasi Jasa</h2>
            <p class="text-xs text-gray-500 font-medium mt-1">Isi detail jasa yang ingin Anda tawarkan kepada pelanggan.</p>
        </div>

        <div class="p-8">
            <form action="{{ route('vendor.jasa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="nama_jasa" class="block text-sm font-bold text-gray-700 mb-1">Nama Jasa</label>
                    <input id="nama_jasa" name="nama_jasa" type="text" value="{{ old('nama_jasa') }}"
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
                            <option value="Cleaning" {{ old('kategori') == 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                            <option value="Repair" {{ old('kategori') == 'Repair' ? 'selected' : '' }}>Repair</option>
                            <option value="Creative" {{ old('kategori') == 'Creative' ? 'selected' : '' }}>Creative</option>
                            <option value="Business" {{ old('kategori') == 'Business' ? 'selected' : '' }}>Business</option>
                        </select>
                        @error('kategori')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="harga" class="block text-sm font-bold text-gray-700 mb-1">Harga (Rp)</label>
                        <input id="harga" name="harga" type="number" value="{{ old('harga') }}"
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
                        placeholder="Jelaskan detail layanan Anda...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Foto Jasa (min. 3 foto)</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="gambar" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <span class="material-symbols-outlined text-gray-400 mb-2">cloud_upload</span>
                                <p class="text-xs text-gray-500">PNG, JPG atau JPEG (Maks. 5MB/file) — Pilih 3 foto</p>
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
                    <p class="text-xs text-gray-400 mt-2" id="file-count">Belum ada file dipilih</p>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:underline font-medium">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-[#003fb1] text-white rounded-xl text-sm font-bold hover:opacity-90 transition-all shadow-lg shadow-blue-100">
                        Publikasikan Jasa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('gambar').addEventListener('change', function() {
    const count = this.files.length;
    document.getElementById('file-count').textContent = count + ' file dipilih' + (count < 3 ? ' (min. 3)' : '');
});
</script>
@endsection