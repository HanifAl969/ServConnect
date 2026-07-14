@extends('layouts.admin')

@section('title', 'Semua Booking — ServeConnect')

@section('header', 'Semua Booking')

@section('content')
<a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#003fb1] mb-4 transition-colors">
    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
    Kembali ke Dashboard
</a>
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Daftar Booking</h2>
            <p class="text-xs text-gray-500 font-medium mt-1">Seluruh transaksi booking di platform</p>
        </div>
        <span class="px-3 py-1.5 bg-purple-50 text-purple-600 rounded-lg text-xs font-bold">
            {{ $bookings->total() }} Total
        </span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white border-b border-gray-50 text-[11px] uppercase text-gray-400 font-bold tracking-widest">
                <tr>
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">User</th>
                    <th class="px-6 py-4">Vendor</th>
                    <th class="px-6 py-4">Jasa</th>
                    <th class="px-6 py-4">Kontak</th>
                    <th class="px-6 py-4">Alamat</th>
                    <th class="px-6 py-4">Waktu</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Pembayaran</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm font-mono text-gray-400">#{{ $booking->id }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-[#003fb1] font-bold text-xs">
                                {{ substr($booking->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $booking->user->name }}</p>
                                <p class="text-[11px] text-gray-400">{{ $booking->user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-green-600 font-bold text-xs">
                                {{ substr($booking->vendor->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $booking->vendor->name }}</p>
                                <p class="text-[11px] text-gray-400">{{ $booking->vendor->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            @php $firstImg = is_array($booking->jasa->gambar) ? ($booking->jasa->gambar[0] ?? null) : $booking->jasa->gambar; @endphp
                            @if($firstImg)
                                <div class="w-8 h-8 rounded-lg overflow-hidden border border-gray-200 shrink-0">
                                    <img src="{{ asset('storage/jasa/' . $firstImg) }}" class="w-full h-full object-cover" alt="">
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $booking->jasa->nama_jasa ?? '-' }}</p>
                                <p class="text-[10px] text-gray-400">{{ $booking->jasa->kategori ?? '' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $booking->phone ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-[180px] truncate" title="{{ $booking->address }}">{{ $booking->address ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        @if($booking->preferred_time)
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">schedule</span>
                                {{ ucfirst($booking->preferred_time) }}
                            </span>
                        @else
                            <span class="text-gray-300">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase 
                            {{ $booking->status == 'accepted' ? 'bg-green-50 text-green-600' : 
                               ($booking->status == 'completed' ? 'bg-blue-50 text-blue-600' :
                               ($booking->status == 'cancelled' ? 'bg-red-50 text-red-600' : 
                                'bg-yellow-50 text-yellow-600')) }}">
                            {{ $booking->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($booking->payment)
                            <div class="space-y-1">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase
                                    {{ $booking->payment->status == 'success' ? 'bg-green-50 text-green-600' : 'bg-yellow-50 text-yellow-600' }}">
                                    {{ $booking->payment->status }}
                                </span>
                                @if($booking->payment->payment_proof)
                                    <div>
                                        <a href="{{ asset('storage/' . $booking->payment->payment_proof) }}" target="_blank"
                                           class="inline-flex items-center gap-1 text-[10px] text-[#003fb1] font-bold hover:underline">
                                            <span class="material-symbols-outlined text-[12px]">open_in_new</span>
                                            Lihat Bukti
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @else
                            <span class="text-gray-300 text-[10px]">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($booking->photos && count($booking->photos) > 0)
                            <div class="flex gap-1">
                                @foreach(array_slice($booking->photos, 0, 3) as $photo)
                                    <a href="{{ asset('storage/' . $photo) }}" target="_blank"
                                       class="block w-7 h-7 rounded border border-gray-200 overflow-hidden hover:ring-1 hover:ring-[#003fb1]">
                                        <img src="{{ asset('storage/' . $photo) }}" class="w-full h-full object-cover" alt="">
                                    </a>
                                @endforeach
                                @if(count($booking->photos) > 3)
                                    <span class="text-[10px] text-gray-400 font-bold self-center">+{{ count($booking->photos) - 3 }}</span>
                                @endif
                            </div>
                        @else
                            <span class="text-gray-300 text-[10px]">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="px-6 py-12 text-center text-gray-400 text-sm">Belum ada booking.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($bookings->hasPages())
    <div class="p-4 border-t border-gray-50">
        {{ $bookings->links() }}
    </div>
    @endif
</div>
@endsection
