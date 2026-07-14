@extends('layouts.vendor')

@section('title', 'Dashboard Vendor — ServeConnect')

@section('header', 'Dashboard Vendor')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    @php
        $userId = Auth::id();
        $jasaCount = \App\Models\Jasa::where('user_id', $userId)->count();
        $pendingBookings = \App\Models\Booking::where('vendor_id', $userId)->where('status', 'pending')->count();
        $acceptedBookings = \App\Models\Booking::where('vendor_id', $userId)->where('status', 'accepted')->count();
        $completedBookings = \App\Models\Booking::where('vendor_id', $userId)->where('status', 'completed')->count();
        $totalRevenue = \App\Models\Booking::where('vendor_id', $userId)->where('status', 'completed')
            ->whereHas('payment', fn($q) => $q->where('status', 'success'))
            ->with('jasa')->get()->sum(fn($b) => $b->jasa->harga);
        $totalViews = \App\Models\Jasa::where('user_id', $userId)->sum('views');
    @endphp

    <a href="{{ route('dashboard') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group">
        <div class="flex justify-between items-start mb-3">
            <div class="p-2.5 bg-blue-50 rounded-xl group-hover:bg-blue-100 transition-colors">
                <span class="material-symbols-outlined text-[#003fb1]">handyman</span>
            </div>
        </div>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Jasa Aktif</p>
        <h3 class="text-xl font-extrabold text-gray-900 mt-1">{{ $jasaCount }}</h3>
    </a>

    <a href="{{ route('vendor.bookings') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-orange-200 transition-all group">
        <div class="flex justify-between items-start mb-3">
            <div class="p-2.5 bg-orange-50 rounded-xl group-hover:bg-orange-100 transition-colors">
                <span class="material-symbols-outlined text-orange-600">pending</span>
            </div>
        </div>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Booking Masuk</p>
        <h3 class="text-xl font-extrabold text-gray-900 mt-1">{{ $pendingBookings }}</h3>
    </a>

    <a href="{{ route('vendor.bookings') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all group">
        <div class="flex justify-between items-start mb-3">
            <div class="p-2.5 bg-green-50 rounded-xl group-hover:bg-green-100 transition-colors">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
            </div>
        </div>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Diterima</p>
        <h3 class="text-xl font-extrabold text-gray-900 mt-1">{{ $acceptedBookings }}</h3>
    </a>

    <a href="{{ route('vendor.bookings') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-teal-200 transition-all group">
        <div class="flex justify-between items-start mb-3">
            <div class="p-2.5 bg-teal-50 rounded-xl group-hover:bg-teal-100 transition-colors">
                <span class="material-symbols-outlined text-teal-600">task_alt</span>
            </div>
        </div>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Selesai</p>
        <h3 class="text-xl font-extrabold text-gray-900 mt-1">{{ $completedBookings }}</h3>
    </a>

    <a href="{{ route('vendor.bookings') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all group">
        <div class="flex justify-between items-start mb-3">
            <div class="p-2.5 bg-emerald-50 rounded-xl group-hover:bg-emerald-100 transition-colors">
                <span class="material-symbols-outlined text-emerald-600">payments</span>
            </div>
        </div>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Pemasukan</p>
        <h3 class="text-lg font-extrabold text-gray-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
    </a>

    <a href="{{ route('dashboard') }}" class="block bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-violet-200 transition-all group">
        <div class="flex justify-between items-start mb-3">
            <div class="p-2.5 bg-violet-50 rounded-xl group-hover:bg-violet-100 transition-colors">
                <span class="material-symbols-outlined text-violet-600">visibility</span>
            </div>
        </div>
        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Dilihat</p>
        <h3 class="text-xl font-extrabold text-gray-900 mt-1">{{ number_format($totalViews) }}</h3>
    </a>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Jasa Saya</h2>
                <p class="text-xs text-gray-500 font-medium mt-1">Kelola layanan jasa yang Anda tawarkan</p>
            </div>
            <a href="{{ route('vendor.jasa.create') }}" class="px-4 py-2 bg-[#003fb1] text-white rounded-xl text-xs font-bold shadow-lg shadow-blue-100 hover:opacity-90 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">add</span>
                Tambah Jasa
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-white border-b border-gray-50 text-[11px] uppercase text-gray-400 font-bold tracking-widest">
                    <tr>
                        <th class="px-6 py-4">Jasa</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Pendapatan</th>
                        <th class="px-6 py-4">Dilihat</th>
                        <th class="px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($jasas as $jasa)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-gray-100 overflow-hidden border border-gray-200 flex-shrink-0">
                                    @php $firstImg = is_array($jasa->gambar) ? ($jasa->gambar[0] ?? null) : $jasa->gambar; @endphp
                                    <img src="{{ $firstImg ? asset('storage/jasa/' . $firstImg) : 'https://ui-avatars.com/api/?name=' . urlencode($jasa->nama_jasa) . '&background=003fb1&color=fff' }}"
                                         class="w-full h-full object-cover"
                                         alt="{{ $jasa->nama_jasa }}"
                                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($jasa->nama_jasa) }}&background=003fb1&color=fff';">
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $jasa->nama_jasa }}</p>
                                    <p class="text-[11px] text-gray-400 line-clamp-1">{{ $jasa->deskripsi }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase bg-blue-50 text-blue-600">
                                {{ $jasa->kategori ?? 'Service' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-900">Rp {{ number_format($jasa->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm font-bold text-green-600">Rp {{ number_format(($jasa->completed_count ?? 0) * $jasa->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ number_format($jasa->views ?? 0) }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('vendor.jasa.edit', $jasa) }}" class="text-[#003fb1] text-xs font-bold hover:underline">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <span class="material-symbols-outlined text-gray-200 text-5xl mb-4 block">inventory_2</span>
                            <p class="text-gray-400 font-medium">Belum ada jasa yang ditawarkan.</p>
                            <a href="{{ route('vendor.jasa.create') }}" class="mt-3 inline-block px-4 py-2 bg-[#003fb1] text-white rounded-xl text-xs font-bold">Tambah Jasa Sekarang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Aksi Cepat</h2>
            <div class="space-y-3">
                <a href="{{ route('vendor.jasa.create') }}" class="flex items-center gap-4 p-4 bg-gray-50 border border-gray-100 rounded-xl hover:border-[#003fb1] hover:bg-[#e7eefe] transition-all group">
                    <div class="w-10 h-10 bg-[#003fb1] text-white rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">add_circle</span>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-gray-900">Tambah Jasa Baru</p>
                        <p class="text-[11px] text-gray-400">Posting layanan jasa terbaru</p>
                    </div>
                </a>
                <a href="{{ route('vendor.bookings') }}" class="flex items-center gap-4 p-4 bg-gray-50 border border-gray-100 rounded-xl hover:border-[#003fb1] hover:bg-[#e7eefe] transition-all group">
                    <div class="w-10 h-10 bg-orange-500 text-white rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">receipt_long</span>
                    </div>
                    <div>
                        <p class="font-bold text-sm text-gray-900">Lihat Booking Masuk</p>
                        <p class="text-[11px] text-gray-400">{{ $pendingBookings }} menunggu konfirmasi</p>
                    </div>
                </a>
            </div>
        </div>

        @php
            $userKategori = \App\Models\Jasa::where('user_id', Auth::id())->first()?->kategori;
            $talentVendors = $userKategori
                ? \App\Models\User::where('role', 'vendor')->where('status', 'active')->where('id', '!=', Auth::id())
                    ->whereHas('jasas', fn($q) => $q->where('kategori', $userKategori))
                    ->withCount([
                        'jasas' => fn($q) => $q->where('kategori', $userKategori),
                        'vendorBookings as bookings_accepted_count' => fn($q) => $q->whereIn('status', ['accepted', 'completed']),
                    ])
                    ->get()
                : collect();
        @endphp
        @if($talentVendors->isNotEmpty())
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Talent di {{ $userKategori }}</h2>
                <p class="text-xs text-gray-500 mb-4">Vendor lain yang menyediakan jasa serupa.</p>
                <div class="space-y-4">
                    @foreach($talentVendors as $tv)
                        @php $tvAccepted = $tv->bookings_accepted_count ?? 0; @endphp
                        <a href="{{ route('jasa.show', \App\Models\Jasa::where('user_id', $tv->id)->where('kategori', $userKategori)->first()) }}"
                           class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 hover:border-[#003fb1] hover:bg-blue-50/30 transition-all">
                            <img class="w-10 h-10 rounded-full object-cover border border-white shrink-0"
                                 src="https://i.pravatar.cc/200?u={{ $tv->email }}"
                                 alt="{{ $tv->name }}">
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $tv->name }}</p>
                                <p class="text-[10px] text-gray-400">{{ $tv->jasas_count }} jasa
                                    @if($tvAccepted > 0) &bull; {{ $tvAccepted }} selesai @endif</p>
                            </div>
                            @if($tv->jasas_count >= 5)
                                <span class="text-[10px] font-bold text-blue-600 shrink-0">Professional</span>
                            @elseif($tvAccepted > 10)
                                <span class="text-[10px] font-bold text-green-600 shrink-0">Populer</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Notifikasi Terbaru</h2>
            <div class="space-y-6">
                @php $notif = auth()->user()->notifications()->latest()->take(3)->get(); @endphp
                @forelse ($notif as $n)
                    <div class="flex gap-4">
                        <div class="w-2 h-2 mt-2 rounded-full bg-blue-600 shrink-0"></div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ $n->data['message'] ?? 'Notifikasi' }}</p>
                            <p class="text-[10px] text-gray-300 font-bold mt-2 uppercase">{{ $n->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div class="flex gap-4">
                        <div class="w-2 h-2 mt-2 rounded-full bg-gray-300 shrink-0"></div>
                        <div>
                            <p class="text-sm text-gray-500">Belum ada notifikasi.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <a href="{{ route('notifications.index') }}" class="block w-full py-3 bg-gray-50 rounded-xl text-xs font-bold text-gray-500 hover:bg-gray-100 transition-all text-center mt-6">
                Lihat Semua Notifikasi
            </a>
        </div>
    </div>
</div>
@endsection