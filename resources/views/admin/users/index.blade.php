<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola User</h2>
            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-1 hover:bg-blue-700 transition">
                <span class="material-symbols-outlined text-[20px]"></span> Tambah User
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 border-l-4 border-green-500 rounded-r shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 border-l-4 border-red-500 rounded-r shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="p-4 font-bold text-gray-700">Nama</th>
                            <th class="p-4 font-bold text-gray-700">Email</th>
                            <th class="p-4 font-bold text-gray-700">Role</th>
                            <th class="p-4 font-bold text-gray-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 text-gray-900 font-medium">{{ $user->name }}</td>
                            <td class="p-4 text-gray-600">{{ $user->email }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 rounded text-[10px] font-bold uppercase {{ $user->role == 'admin' ? 'bg-red-100 text-red-700' : ($user->role == 'vendor' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700') }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex justify-center gap-3">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800 transition">
                                        <span class="material-symbols-outlined">edit</span>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4 border-t bg-gray-50">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>