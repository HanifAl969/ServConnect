<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Akun: {{ $user->name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="$user->name" required />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="$user->email" required />
                    </div>

                    <div>
                        <x-input-label for="role" :value="__('Role')" />
                        <select name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                            <option value="vendor" {{ $user->role == 'vendor' ? 'selected' : '' }}>Vendor</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg border border-dashed">
                        <x-input-label for="password" :value="__('Ganti Password (Opsional)')" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" placeholder="Isi hanya jika ingin ganti password" />
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4">
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:underline">Batal</a>
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700">Simpan Perubahan</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>