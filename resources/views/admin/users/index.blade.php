@extends('layouts.admin')

@section('title', 'Kelola User — ServeConnect')

@section('header', 'Kelola User')

@section('content')
<a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#003fb1] mb-4 transition-colors">
    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
    Kembali ke Dashboard
</a>
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
        <div>
            <p class="text-xs text-gray-500 font-medium">Total {{ $users->total() }} user terdaftar</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-[#003fb1] text-white rounded-xl text-xs font-bold shadow-lg shadow-blue-100 hover:opacity-90 transition-all flex items-center gap-1">
            <span class="material-symbols-outlined text-[16px]">add</span> Tambah User
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white border-b border-gray-50 text-[11px] uppercase text-gray-400 font-bold tracking-widest">
                <tr>
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Role</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center text-[#003fb1] font-bold text-xs border border-gray-200">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $user->name }}</p>
                                <p class="text-[11px] text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase {{ $user->role == 'admin' ? 'bg-red-50 text-red-600' : ($user->role == 'vendor' ? 'bg-green-50 text-green-600' : 'bg-blue-50 text-blue-600') }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-[12px] font-medium {{ $user->status == 'active' ? 'text-green-600' : ($user->status == 'pending' ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-[#003fb1] text-xs font-bold hover:underline flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">edit</span> Edit
                            </a>
                            @if ($user->id !== Auth::id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus user {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 text-xs font-bold hover:underline flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">delete</span> Hapus
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-50">
        {{ $users->links() }}
    </div>
</div>
@endsection
