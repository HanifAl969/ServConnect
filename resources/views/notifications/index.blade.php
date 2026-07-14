@php
    $layout = Auth::user()->role === 'admin' ? 'layouts.admin' : (Auth::user()->role === 'vendor' ? 'layouts.vendor' : 'layouts.user');
@endphp
@extends($layout)

@section('header', 'Notifikasi')
@section('subheader', 'Semua pemberitahuan Anda')

@section('content')
    <div class="max-w-3xl mx-auto">
        <a href="{{ Auth::user()->role === 'user' ? route('bookings.index') : route('dashboard') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#003fb1] mb-4 transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali
        </a>
        @if ($notifications->isEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <span class="material-symbols-outlined text-5xl text-gray-300 mb-4">notifications_off</span>
                <p class="text-gray-500 font-medium">Tidak ada notifikasi.</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($notifications as $notification)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 {{ $notification->read_at ? '' : 'border-l-4 border-l-blue-500 ring-1 ring-blue-50' }}">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex items-start gap-3 min-w-0">
                                <span class="material-symbols-outlined mt-0.5 {{ $notification->read_at ? 'text-gray-400' : 'text-blue-500' }}">
                                    {{ $notification->read_at ? 'notifications' : 'notifications_active' }}
                                </span>
                                <div class="min-w-0">
                                    <p class="text-sm text-gray-700 break-words">{{ $notification->data['message'] ?? '' }}</p>
                                    @if (isset($notification->data['jasa']))
                                        <p class="text-xs text-gray-400 mt-1">Jasa: {{ $notification->data['jasa'] }}</p>
                                    @endif
                                </div>
                            </div>
                            <span class="text-xs text-gray-400 whitespace-nowrap shrink-0">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endSection