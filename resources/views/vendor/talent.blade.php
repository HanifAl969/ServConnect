@extends('layouts.vendor')

@section('title', 'Kelola Agent — ServeConnect')

@section('header', 'Agent Saya')

@section('subheader', 'Kelola profil talent dan sertifikat kompetensi Anda')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- Profil Agent --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 text-center">
            <img class="w-24 h-24 rounded-full object-cover border-4 border-blue-50 mx-auto mb-4"
                 src="https://i.pravatar.cc/200?u={{ Auth::user()->email }}"
                 alt="{{ Auth::user()->name }}">
            <h3 class="font-bold text-lg text-gray-900">{{ Auth::user()->name }}</h3>
            <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>

            <div class="mt-4 flex justify-center gap-2">
                @if(Auth::user()->vendor_type === 'enterprise')
                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-emerald-100 text-emerald-700">
                        <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                        Perusahaan Terpercaya
                    </span>
                @elseif(Auth::user()->vendor_type === 'umkm')
                    <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold bg-blue-100 text-blue-700">
                        UMKM
                    </span>
                @endif
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 text-left space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Jasa Aktif</span>
                    <span class="font-bold text-gray-900">{{ Auth::user()->jasas->count() }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Status</span>
                    <span class="font-bold text-green-600">{{ ucfirst(Auth::user()->status) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Sertifikat</span>
                    <span class="font-bold text-gray-900">{{ Auth::user()->certificates->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Sertifikat --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Daftar Sertifikat --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-gray-900">Sertifikat Kompetensi</h3>
                    <p class="text-xs text-gray-500">Sertifikat yang sudah dilampirkan</p>
                </div>
            </div>
            <div class="p-6">
                @if(Auth::user()->certificates->isEmpty())
                    <div class="text-center py-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                        <span class="material-symbols-outlined text-gray-300 text-4xl">assignment</span>
                        <p class="text-gray-400 text-sm mt-2">Belum ada sertifikat.</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach(Auth::user()->certificates as $cert)
                            <div class="relative group">
                                <a href="{{ $cert->fileUrl() }}" target="_blank">
                                    <img src="{{ $cert->fileUrl() }}"
                                         class="w-full h-32 object-cover rounded-lg border border-gray-200 hover:opacity-80 transition-opacity" />
                                </a>
                                <p class="text-xs font-medium text-gray-700 mt-1 truncate">{{ $cert->certificate_name ?? 'Sertifikat' }}</p>
                                <form action="{{ route('vendor.certificate.delete', $cert) }}" method="POST"
                                      onsubmit="return confirm('Hapus sertifikat ini?')" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-7 h-7 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 text-sm">
                                        <span class="material-symbols-outlined text-[16px]">close</span>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Upload Sertifikat Baru --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h3 class="font-bold text-gray-900 mb-1">Tambah Sertifikat</h3>
            <p class="text-xs text-gray-500 mb-4">Upload sertifikat kompetensi baru (JPG/PNG, max 5MB)</p>
            <form action="{{ route('vendor.certificate.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <input type="text" name="certificate_name" placeholder="Nama sertifikat (opsional)"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm" />
                </div>
                <div class="flex items-center gap-4">
                    <input type="file" name="certificate" accept="image/jpg,image/jpeg,image/png" required
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-4 focus:ring-[#003fb1]/10 focus:border-[#003fb1] outline-none transition-all text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-[#003fb1] file:text-white hover:file:bg-blue-700" />
                    <button type="submit" class="shrink-0 px-6 py-3 bg-[#003fb1] text-white rounded-xl font-bold text-sm hover:bg-blue-700 transition shadow-lg shadow-blue-100">
                        Upload
                    </button>
                </div>
                @error('certificate') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                @error('certificate_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </form>
        </div>

        {{-- Semua Agent --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                <h3 class="font-bold text-gray-900">Semua Talent Terdaftar</h3>
                <p class="text-xs text-gray-500">Vendor lain yang aktif di platform</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white border-b border-gray-50 text-[11px] uppercase text-gray-400 font-bold tracking-widest">
                        <tr>
                            <th class="px-6 py-4">Talent</th>
                            <th class="px-6 py-4">Tipe</th>
                            <th class="px-6 py-4">Sertifikat</th>
                            <th class="px-6 py-4">Jasa</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($agents as $agent)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img class="w-8 h-8 rounded-full object-cover" src="https://i.pravatar.cc/200?u={{ $agent->email }}" alt="{{ $agent->name }}">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $agent->name }}</p>
                                        <p class="text-[11px] text-gray-400">{{ $agent->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($agent->vendor_type === 'enterprise')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-emerald-100 text-emerald-700">
                                        <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                                        Perusahaan
                                    </span>
                                @elseif($agent->vendor_type === 'umkm')
                                    <span class="px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-blue-100 text-blue-700">UMKM</span>
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $agent->certificates->count() }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $agent->jasas_count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
