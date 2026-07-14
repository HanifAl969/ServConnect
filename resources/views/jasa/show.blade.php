<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-authenticated" content="{{ auth()->check() ? '1' : '0' }}">
    <title>{{ $jasa->nama_jasa }} — ServeConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24; }
        .swiper { width: 100%; height: 100%; }
        .swiper-slide { display: flex; align-items: center; justify-content: center; }
        .swiper-slide img { width: 100%; height: 100%; object-fit: cover; }
        .swiper-button-next, .swiper-button-prev { color: #003fb1; background: white; width: 40px; height: 40px; border-radius: 50%; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .swiper-button-next::after, .swiper-button-prev::after { font-size: 16px; font-weight: bold; }
        .swiper-pagination-bullet-active { background: #003fb1; }
    </style>
</head>
<body class="bg-[#f9f9ff] text-[#151c27] antialiased">

<nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between relative">
        <a href="/" class="text-xl font-bold tracking-tight text-[#003fb1]">ServeConnect</a>
        <div class="hidden md:flex items-center gap-6 absolute left-1/2 -translate-x-1/2">
            <a class="text-gray-600 hover:text-[#003fb1] transition-colors text-sm font-semibold" href="/">Beranda</a>
            <a class="text-gray-600 hover:text-[#003fb1] transition-colors text-sm font-semibold" href="/#kategori">Kategori</a>
            <a class="text-gray-600 hover:text-[#003fb1] transition-colors text-sm font-semibold" href="/#jasa">Jasa</a>
            <a class="text-gray-600 hover:text-[#003fb1] transition-colors text-sm font-semibold" href="{{ route('about') }}">Tentang Kami</a>
        </div>
        <div class="flex items-center gap-3">
            @auth
                @php $unreadCount = Auth::user()->unreadNotifications()->count(); @endphp
                <a href="{{ route('notifications.index') }}" class="relative p-2 hover:bg-gray-50 rounded-xl transition-all hidden md:block">
                    <span class="material-symbols-outlined text-gray-500">notifications</span>
                    @if($unreadCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    @endif
                </a>
                <div class="relative">
                    <button onclick="toggleDropdown()" class="flex items-center gap-2 px-3 py-1.5 rounded-xl hover:bg-gray-50 transition-all">
                        <img class="w-8 h-8 rounded-full object-cover border-2 border-blue-50" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=003fb1&color=fff" alt="Profile"/>
                        <span class="text-sm font-bold text-gray-900 hidden sm:block">{{ Auth::user()->name }}</span>
                        <span class="material-symbols-outlined text-gray-400 text-[18px]">expand_more</span>
                    </button>
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                        @if(Auth::user()->role !== 'user')
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
                        @endif
                        <a href="{{ route('bookings.index') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">Booking</a>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 font-medium">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 hover:text-[#003fb1] px-4 py-2 transition">Masuk</a>
                <a href="{{ route('register') }}" class="bg-[#003fb1] text-white hover:opacity-90 transition-all px-5 py-2.5 rounded-lg font-bold text-sm shadow-md shadow-blue-200">Daftar</a>
            @endauth
        </div>
    </div>
</nav>

<main class="pt-24 pb-16">
    <div class="max-w-6xl mx-auto px-6">
        <a href="/" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#003fb1] mb-6 transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Beranda
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-16">
            {{-- Image Slider --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                @php $images = is_array($jasa->gambar) ? $jasa->gambar : []; @endphp
                @if(count($images) > 0)
                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach($images as $img)
                                <div class="swiper-slide">
                                    <img src="{{ asset('storage/jasa/' . $img) }}"
                                         alt="{{ $jasa->nama_jasa }}"
                                         class="w-full h-[400px] object-cover"
                                         onerror="this.onerror=null; this.src='https://picsum.photos/seed/{{ urlencode($jasa->nama_jasa) }}/400/300';">
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                @else
                    <div class="w-full h-[400px] bg-gray-100 flex items-center justify-center">
                        <img src="https://picsum.photos/seed/{{ urlencode($jasa->nama_jasa) }}/400/300"
                             class="w-full h-full object-cover"
                             alt="{{ $jasa->nama_jasa }}">
                    </div>
                @endif
            </div>

            {{-- Detail Info --}}
            <div>
                <span class="inline-block px-3 py-1.5 bg-blue-50 text-[#003fb1] rounded-lg text-xs font-bold uppercase tracking-wider mb-4">{{ $jasa->kategori }}</span>
                <h1 class="text-3xl font-extrabold text-[#151c27] mb-3">{{ $jasa->nama_jasa }}</h1>
                <p class="text-2xl font-bold text-green-600 mb-6">Rp {{ number_format($jasa->harga, 0, ',', '.') }}</p>

                <div class="flex items-center gap-3 mb-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <img class="w-12 h-12 rounded-full object-cover border-2 border-white" src="https://ui-avatars.com/api/?name={{ urlencode($jasa->user->name ?? 'Vendor') }}&background=003fb1&color=fff" alt="{{ $jasa->user->name }}">
                    <div>
                        <p class="text-sm font-bold text-gray-900">{{ $jasa->user->name ?? 'Penyedia Jasa' }}</p>
                        <p class="text-xs text-gray-500">Penyedia layanan</p>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="font-bold text-gray-900 mb-2">Deskripsi</h3>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $jasa->deskripsi }}</p>
                </div>
            </div>
        </div>

        {{-- Pilih Agent --}}
        <section>
            <div class="mb-8">
                <h2 class="text-2xl font-extrabold text-[#151c27]">Pilih Talent / Agent</h2>
                <p class="text-gray-500 mt-1">Pilih penyedia jasa profesional untuk layanan {{ $jasa->kategori }}.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($agents as $agent)
                    @php
                        $accepted = $agent->bookings_accepted_count ?? 0;
                    @endphp
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-[#003fb1] transition-all text-center">
                        <div class="flex flex-col items-center mb-4">
                            <img class="w-20 h-20 rounded-full object-cover border-4 border-blue-50 mb-3"
                                 src="https://i.pravatar.cc/200?u={{ $agent->email }}"
                                 alt="{{ $agent->name }}">
                            <h3 class="font-bold text-base text-gray-900">{{ $agent->name }}</h3>
                            <p class="text-xs text-gray-400 font-medium">{{ $agent->jasas_count }} jasa {{ $jasa->kategori }}</p>
                            @if($accepted > 0)
                                <p class="text-xs text-gray-400">{{ $accepted }} pesanan selesai</p>
                            @endif
                        </div>

                        @if($agent->jasas && $agent->jasas->isNotEmpty())
                            <div class="text-left mb-4 space-y-2">
                                @foreach($agent->jasas->take(2) as $aj)
                                    <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                        <p class="text-xs font-bold text-gray-900 truncate">{{ $aj->nama_jasa }}</p>
                                        <p class="text-[11px] text-gray-500 leading-relaxed line-clamp-2">{{ $aj->deskripsi }}</p>
                                    </div>
                                @endforeach
                                @if($agent->jasas->count() > 2)
                                    <p class="text-[10px] text-gray-400 text-center font-medium">+{{ $agent->jasas->count() - 2 }} jasa lainnya</p>
                                @endif
                            </div>
                        @endif

                        <div class="flex flex-wrap justify-center gap-2 mb-4">
                            @if($agent->vendor_type === 'enterprise')
                                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-lg inline-flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[12px]" style="font-variation-settings: 'FILL' 1;">verified</span>
                                    Perusahaan Terpercaya
                                </span>
                            @elseif($agent->vendor_type === 'umkm')
                                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg">UMKM</span>
                            @endif
                            @if($agent->jasas_count >= 5)
                                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg">Professional</span>
                            @endif
                            @if($accepted > 10)
                                <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2.5 py-1 rounded-lg">Populer</span>
                            @endif
                        </div>

                        @auth
                            <a href="{{ route('booking.create', ['jasa' => $jasa, 'vendor' => $agent->id]) }}"
                               class="block w-full text-center py-2.5 bg-[#003fb1] text-white rounded-xl text-xs font-bold hover:opacity-90 transition-all shadow-lg shadow-blue-100">
                                Pesan Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}?redirect={{ urlencode(route('booking.create', ['jasa' => $jasa, 'vendor' => $agent->id])) }}"
                               class="block w-full text-center py-2.5 bg-[#003fb1] text-white rounded-xl text-xs font-bold hover:opacity-90 transition-all shadow-lg shadow-blue-100">
                                Masuk untuk Pesan
                            </a>
                        @endauth
                    </div>
                @endforeach
            </div>

            @if($agents->isEmpty())
                <div class="text-center py-16 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                    <span class="material-symbols-outlined text-gray-300 text-6xl mb-4">group_off</span>
                    <p class="text-gray-400 font-medium">Belum ada talent tersedia untuk kategori ini.</p>
                </div>
            @endif
        </section>
    </div>
</main>

<footer class="bg-white border-t border-gray-200 py-12">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
            <div class="md:col-span-2">
                <h3 class="text-xl font-bold text-[#003fb1] mb-4">ServeConnect</h3>
                <p class="text-sm text-gray-500 max-w-md">Platform terpercaya yang menghubungkan Anda dengan penyedia jasa profesional terbaik di Indonesia.</p>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-3 text-sm">Navigasi</h4>
                <ul class="space-y-2 text-sm text-gray-500">
                    <li><a href="/" class="hover:text-[#003fb1] transition-colors">Beranda</a></li>
                    <li><a href="/#kategori" class="hover:text-[#003fb1] transition-colors">Kategori</a></li>
                    <li><a href="/#jasa" class="hover:text-[#003fb1] transition-colors">Jasa</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-[#003fb1] transition-colors">Tentang Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 mb-3 text-sm">Akun</h4>
                <ul class="space-y-2 text-sm text-gray-500">
                    @auth
                        <li><a href="{{ route('dashboard') }}" class="hover:text-[#003fb1] transition-colors">Dashboard</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="hover:text-[#003fb1] transition-colors">Pengaturan</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-[#003fb1] transition-colors">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-[#003fb1] transition-colors">Daftar</a></li>
                    @endauth
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-100 pt-8 text-center text-sm text-gray-400">
            &copy; 2026 ServeConnect. Solusi jasa terpercaya Anda.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
var swiper = new Swiper('.mySwiper', {
    loop: true,
    pagination: { el: '.swiper-pagination', clickable: true },
    navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    keyboard: { enabled: true },
});
function toggleDropdown() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('hidden');
}
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('userDropdown');
    if (!dropdown) return;
    const button = dropdown.previousElementSibling;
    if (button && !button.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.add('hidden');
    }
});
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown) dropdown.classList.add('hidden');
    }
});
</script>

@include('components.floating-chat', ['category' => $jasa->kategori])
</body>
</html>
