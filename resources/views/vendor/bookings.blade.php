@extends('layouts.vendor')

@section('title', 'Booking Masuk — ServeConnect')

@section('header', 'Booking Masuk')

@section('content')
<a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#003fb1] mb-4 transition-colors">
    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
    Kembali ke Dashboard
</a>
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Daftar Booking</h2>
            <p class="text-xs text-gray-500 font-medium mt-1">Booking dari pelanggan untuk jasa Anda</p>
        </div>
        <span class="px-3 py-1.5 bg-blue-50 text-[#003fb1] rounded-lg text-xs font-bold">
            {{ $bookings->count() }} Total
        </span>
    </div>

    @if ($bookings->isEmpty())
        <div class="p-16 text-center">
            <span class="material-symbols-outlined text-gray-200 text-6xl mb-4 block">receipt_long</span>
            <p class="text-gray-400 font-medium">Belum ada booking masuk.</p>
        </div>
    @else
        <div class="divide-y divide-gray-50">
            @foreach ($bookings as $booking)
                <div class="p-6 hover:bg-gray-50/50 transition-all">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="font-bold text-gray-900">{{ $booking->jasa->nama_jasa }}</h3>
                                <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase
                                    @if ($booking->status === 'pending') bg-yellow-50 text-yellow-600
                                    @elseif ($booking->status === 'accepted') bg-green-50 text-green-600
                                    @elseif ($booking->status === 'completed') bg-blue-50 text-blue-600
                                    @else bg-red-50 text-red-600 @endif">
                                    {{ $booking->status }}
                                </span>
                            </div>
                            <div class="flex flex-wrap gap-x-6 gap-y-1 text-sm text-gray-500">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">person</span>
                                    {{ $booking->user->name }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">call</span>
                                    {{ $booking->phone }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                    {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                </span>
                                @if ($booking->preferred_time)
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">schedule</span>
                                    {{ ucfirst($booking->preferred_time) }}
                                </span>
                                @endif
                            </div>
                            <div class="mt-2 text-sm text-gray-400">
                                <p class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">location_on</span>
                                    {{ $booking->address }}
                                </p>
                            </div>
                            @if ($booking->photos && count($booking->photos) > 0)
                                <div class="flex flex-wrap gap-2 mt-3">
                                    @foreach ($booking->photos as $photo)
                                        <a href="{{ asset('storage/' . $photo) }}" target="_blank"
                                           class="block w-20 h-20 rounded-lg overflow-hidden border border-gray-200 hover:ring-2 hover:ring-[#003fb1] transition-all">
                                            <img src="{{ asset('storage/' . $photo) }}"
                                                 class="w-full h-full object-cover"
                                                 alt="Foto pelanggan"
                                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Foto&background=ccc&color=fff&size=80';">
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                            @if ($booking->notes)
                                <p class="text-sm text-gray-400 mt-2 italic">Catatan: {{ $booking->notes }}</p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            @if ($booking->status === 'pending')
                                <form action="{{ route('vendor.bookings.update-status', $booking) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="accepted">
                                    <button class="px-5 py-2.5 bg-green-600 text-white rounded-xl text-xs font-bold hover:bg-green-700 transition-all flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[16px]">check</span>
                                        Terima
                                    </button>
                                </form>
                                <form action="{{ route('vendor.bookings.update-status', $booking) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button class="px-5 py-2.5 bg-red-50 text-red-600 rounded-xl text-xs font-bold hover:bg-red-100 transition-all flex items-center gap-2" onclick="return confirm('Tolak booking ini?')">
                                        <span class="material-symbols-outlined text-[16px]">close</span>
                                        Tolak
                                    </button>
                                </form>
                            @elseif ($booking->status === 'accepted')
                                <div class="flex flex-col items-end gap-2">
                                    <a href="{{ route('chat.index', $booking) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-xs font-bold hover:bg-gray-200 transition-all flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[15px]">chat</span>
                                        Chat
                                    </a>
                                    @if ($booking->payment && $booking->payment->status === 'pending')
                                        <div class="text-right">
                                            <div class="mb-2">
                                                <p class="text-xs font-bold text-gray-700 mb-1">Bukti Transfer</p>
                                                @if($booking->payment->payment_proof)
                                                <a href="{{ asset('storage/' . $booking->payment->payment_proof) }}" target="_blank"
                                                   class="block w-16 h-16 rounded-lg overflow-hidden border border-gray-200 hover:ring-2 hover:ring-[#003fb1] transition-all">
                                                    <img src="{{ asset('storage/' . $booking->payment->payment_proof) }}"
                                                         class="w-full h-full object-cover" alt="Bukti transfer">
                                                </a>
                                                @endif
                                            </div>
                                            <form action="{{ route('vendor.bookings.confirm-payment', $booking) }}" method="POST">
                                                @csrf
                                                <button class="px-5 py-2.5 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition-all flex items-center gap-2"
                                                        onclick="return confirm('Konfirmasi pembayaran ini? Booking akan selesai.')">
                                                    <span class="material-symbols-outlined text-[16px]">verified</span>
                                                    Konfirmasi
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-xs text-green-600 font-bold flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                            Diterima
                                        </span>
                                    @endif
                                </div>
                            @elseif ($booking->status === 'completed')
                                <span class="text-xs text-green-600 font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                    Selesai
                                </span>
                                <a href="{{ route('chat.index', $booking) }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl text-xs font-bold hover:bg-gray-200 transition-all flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[15px]">chat</span>
                                    Chat
                                </a>
                            @elseif ($booking->status === 'cancelled')
                                <span class="text-xs text-red-600 font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">cancel</span>
                                    Ditolak
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection