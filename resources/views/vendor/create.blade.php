<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Jasa Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-8 text-gray-900">
                    <header class="mb-6">
                        <h3 class="text-lg font-bold text-blue-700">Informasi Jasa (US4)</h3>
                        <p class="text-sm text-gray-500">Isi detail jasa yang ingin Anda tawarkan kepada pelanggan.</p>
                    </header>

                    <form action="{{ route('vendor.jasa.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="nama_jasa" :value="__('Nama Jasa')" />
                            <x-text-input id="nama_jasa" name="nama_jasa" type="text" class="mt-1 block w-full" placeholder="Contoh: Jasa Cuci AC Bergaransi" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_jasa')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="kategori" :value="__('Kategori')" />
                                <select id="kategori" name="kategori" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Cleaning">Cleaning</option>
                                    <option value="Repair">Repair</option>
                                    <option value="Creative">Creative</option>
                                    <option value="Business">Business</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('kategori')" />
                            </div>
                            <div>
                                <x-input-label for="harga" :value="__('Harga (Rp)')" />
                                <x-text-input id="harga" name="harga" type="number" class="mt-1 block w-full" placeholder="Contoh: 150000" required />
                                <x-input-error class="mt-2" :messages="$errors->get('harga')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="deskripsi" :value="__('Deskripsi Jasa')" />
                            <textarea id="deskripsi" name="deskripsi" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Jelaskan detail layanan Anda..."></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('deskripsi')" />
                        </div>

                        <div>
                            <x-input-label for="gambar" :value="__('Foto Jasa (Opsional)')" />
                            <div class="mt-2 flex items-center justify-center w-full">
                                <label for="gambar" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <span class="material-symbols-outlined text-gray-400 mb-2">cloud_upload</span>
                                        <p class="text-xs text-gray-500">PNG, JPG atau JPEG (Max. 2MB)</p>
                                    </div>
                                    <input id="gambar" name="gambar" type="file" class="hidden" accept="image/*" />
                                </label>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('gambar')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                            <x-primary-button class="bg-blue-700 hover:bg-blue-800">
                                {{ __('Publikasikan Jasa') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</x-app-layout>