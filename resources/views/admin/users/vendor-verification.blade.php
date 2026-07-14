@extends('layouts.admin')

@section('title', 'Verifikasi Vendor — ServeConnect')

@section('header', 'Verifikasi Vendor')

@section('content')
<a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#003fb1] mb-4 transition-colors">
    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
    Kembali ke Dashboard
</a>
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-50 bg-gray-50/50">
        <p class="text-xs text-gray-500 font-medium">Daftar vendor yang menunggu persetujuan</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white border-b border-gray-50 text-[11px] uppercase text-gray-400 font-bold tracking-widest">
                <tr>
                    <th class="px-6 py-4">Vendor</th>
                    <th class="px-6 py-4">Tipe</th>
                    <th class="px-6 py-4">Sertifikat</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach ($vendors as $vendor)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center text-[#003fb1] font-bold text-xs border border-gray-200">
                                {{ substr($vendor->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $vendor->name }}</p>
                                <p class="text-[11px] text-gray-400">{{ $vendor->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if ($vendor->vendor_type === 'enterprise')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                <span class="material-symbols-outlined text-[14px]">verified</span>
                                Perusahaan
                            </span>
                        @elseif ($vendor->vendor_type === 'umkm')
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                UMKM
                            </span>
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if ($vendor->certificates->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach ($vendor->certificates as $cert)
                                    <a href="{{ $cert->fileUrl() }}" target="_blank" class="inline-block" title="{{ $cert->certificate_name ?? 'Sertifikat' }}">
                                        <img src="{{ $cert->fileUrl() }}" class="h-12 w-16 object-cover rounded border border-gray-200 hover:opacity-80 transition-opacity" />
                                    </a>
                                @endforeach
                                @if ($vendor->certificates->count() > 3)
                                    <span class="text-xs text-gray-400 self-center">+{{ $vendor->certificates->count() - 3 }} lagi</span>
                                @endif
                            </div>
                        @else
                            <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                            @if ($vendor->status === 'pending') bg-yellow-100 text-yellow-700
                            @elseif ($vendor->status === 'active') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ ucfirst($vendor->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if ($vendor->status === 'pending')
                            <div class="flex gap-2">
                                <form action="{{ route('admin.vendor.approve', $vendor) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-4 py-2 bg-green-600 text-white rounded-lg text-xs font-semibold hover:bg-green-700 transition">Setujui</button>
                                </form>
                                <form action="{{ route('admin.vendor.reject', $vendor) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="px-4 py-2 bg-red-600 text-white rounded-lg text-xs font-semibold hover:bg-red-700 transition" onclick="return confirm('Tolak vendor ini?')">Tolak</button>
                                </form>
                            </div>
                        @else
                            <span class="text-xs text-gray-400">{{ $vendor->status === 'active' ? 'Terverifikasi' : 'Ditolak' }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-50">
        {{ $vendors->links() }}
    </div>
</div>
@endsection
