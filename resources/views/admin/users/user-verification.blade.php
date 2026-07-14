@extends('layouts.admin')

@section('title', 'Verifikasi KTP User — ServeConnect')

@section('header', 'Verifikasi KTP User')

@section('content')
<a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#003fb1] mb-4 transition-colors">
    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
    Kembali ke Dashboard
</a>
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-50 bg-gray-50/50">
        <p class="text-xs text-gray-500 font-medium">Daftar user yang menunggu verifikasi KTP</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white border-b border-gray-50 text-[11px] uppercase text-gray-400 font-bold tracking-widest">
                <tr>
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Foto KTP</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($users as $user)
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
                        @if ($user->ktp_photo)
                            <a href="{{ asset('storage/' . $user->ktp_photo) }}" target="_blank" class="inline-block">
                                <img src="{{ asset('storage/' . $user->ktp_photo) }}"
                                     class="h-16 w-24 object-cover rounded-lg border border-gray-200 hover:opacity-80 transition-opacity" />
                            </a>
                        @else
                            <span class="text-xs text-gray-400">Belum upload</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                            @if ($user->status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif ($user->status === 'active') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if ($user->status === 'pending' && $user->ktp_photo)
                            <div class="flex gap-2">
                                <form action="{{ route('admin.user.approve', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-xs font-semibold hover:bg-green-700 transition">Setujui</button>
                                </form>
                                <form action="{{ route('admin.user.reject', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-4 py-2 bg-red-600 text-white rounded-lg text-xs font-semibold hover:bg-red-700 transition" onclick="return confirm('Tolak user ini?')">Tolak</button>
                                </form>
                            </div>
                        @else
                            <span class="text-xs text-gray-400">{{ $user->status === 'active' ? 'Terverifikasi' : ($user->status === 'rejected' ? 'Ditolak' : 'Menunggu KTP') }}</span>
                        @endif
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
