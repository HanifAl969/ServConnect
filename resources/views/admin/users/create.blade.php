<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah User Baru (US5)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8 text-gray-900">
                    <header class="mb-6">
                        <h3 class="text-lg font-bold text-blue-700 italic">Informasi Akun</h3>
                        <p class="text-sm text-gray-500">Buat akun baru untuk Admin, Vendor, atau User biasa.</p>
                    </header>

                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Nama Lengkap')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Alamat Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="role" :value="__('Role / Hak Akses')" />
                            <select id="role" name="role" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User (Buyer)</option>
                                <option value="vendor" {{ old('role') == 'vendor' ? 'selected' : '' }}>Vendor (Penyedia Jasa)</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengelola)</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('role')" />
                        </div>

                        <div>
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                            <p class="text-[10px] text-gray-400 mt-1 italic">*Minimal 8 karakter</p>
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                            <x-primary-button class="bg-blue-600 hover:bg-blue-700 shadow-md shadow-blue-100">
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>