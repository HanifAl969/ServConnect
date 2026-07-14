<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-authenticated" content="{{ auth()->check() ? '1' : '0' }}">
    <title>ServeConnect — Temukan Solusi Profesional</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24; }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-[#f9f9ff] text-[#151c27] antialiased">

<nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between relative">
        <a href="/" class="text-xl font-bold tracking-tight text-[#003fb1]">ServeConnect</a>

        <div class="hidden md:flex items-center gap-6 absolute left-1/2 -translate-x-1/2">
            <a class="text-gray-600 hover:text-[#003fb1] transition-colors text-sm font-semibold" href="/">Beranda</a>
            <a class="text-gray-600 hover:text-[#003fb1] transition-colors text-sm font-semibold" href="#kategori">Kategori</a>
            <a class="text-gray-600 hover:text-[#003fb1] transition-colors text-sm font-semibold" href="#jasa">Jasa</a>
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
                <a href="{{ route('register') }}" class="bg-[#003fb1] text-white hover:opacity-90 transition-all px-5 py-2.5 rounded-lg font-bold text-sm shadow-md shadow-blue-200">
                    Daftar
                </a>
            @endauth
        </div>
    </div>
</nav>

<script>
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

<main>
    <section class="relative min-h-[600px] flex items-center overflow-hidden pt-16">
        <div class="absolute inset-0 z-0">
            <img class="w-full h-full object-cover opacity-10 grayscale-[0.5]" src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80" alt="Background"/>
            <div class="absolute inset-0 bg-gradient-to-tr from-white via-white/80 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 relative z-10 w-full py-20">
            <div class="max-w-2xl mx-auto text-center">
                <span class="inline-block px-3 py-1.5 bg-blue-50 text-[#003fb1] rounded-lg text-xs font-bold uppercase tracking-wider mb-4">
                    {{ $vendors }} Vendor Terdaftar
                </span>
                <h1 class="text-5xl font-extrabold text-[#151c27] mb-6 leading-tight">
                    Temukan Solusi Profesional untuk Setiap Kebutuhan Anda
                </h1>
                <p class="text-lg text-gray-600 mb-8 max-w-lg">
                    Platform terpercaya untuk menghubungkan Anda dengan penyedia jasa ahli dalam hitungan menit.
                </p>

                <form action="/" method="GET" class="bg-white p-2 rounded-xl shadow-xl border border-gray-100 flex flex-col md:flex-row items-center justify-center mx-auto gap-2 max-w-3xl">
                    <div class="flex items-center gap-3 px-4 py-3 w-full border-b md:border-b-0 md:border-r border-gray-100">
                        <span class="material-symbols-outlined text-gray-400 shrink-0">search</span>
                        <input name="search" value="{{ request('search') }}" class="w-full border-none focus:ring-0 text-sm text-[#151c27] p-0 outline-none" placeholder="Cari jasa atau kategori..." type="text"/>
                    </div>
                    <div class="flex items-center gap-3 px-4 py-3 w-full md:w-auto min-w-[180px]">
                        <span class="material-symbols-outlined text-gray-400 shrink-0">category</span>
                        <select name="kategori" class="w-full border-none focus:ring-0 text-sm text-gray-500 p-0 outline-none bg-transparent">
                            <option value="">Semua Kategori</option>
                            <option value="Cleaning" {{ request('kategori') == 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                            <option value="Repair" {{ request('kategori') == 'Repair' ? 'selected' : '' }}>Repair</option>
                            <option value="Creative" {{ request('kategori') == 'Creative' ? 'selected' : '' }}>Creative</option>
                            <option value="Business" {{ request('kategori') == 'Business' ? 'selected' : '' }}>Business</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full md:w-auto bg-[#003fb1] text-white px-8 py-3 rounded-lg font-bold hover:opacity-90 transition-all">
                        Cari
                    </button>
                </form>
            </div>
        </div>
    </section>

    <section id="kategori" class="py-20 max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-extrabold text-[#151c27]">Kategori Populer</h2>
                <p class="text-gray-500 mt-2">Jelajahi layanan dari para ahli di bidangnya.</p>
            </div>
            <a href="/" class="text-[#003fb1] font-bold flex items-center gap-2 hover:underline text-sm">
                Lihat Semua
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
        </div>

        @php
            $categories = [
                ['name' => 'Cleaning', 'icon' => 'cleaning_services', 'desc' => 'Kebersihan rumah, kantor, hingga laundry.', 'color' => 'bg-blue-50 text-blue-600'],
                ['name' => 'Repair', 'icon' => 'construction', 'desc' => 'Perbaikan listrik, AC, hingga renovasi.', 'color' => 'bg-orange-50 text-orange-600'],
                ['name' => 'Creative', 'icon' => 'palette', 'desc' => 'Desain grafis, fotografi, hingga copywriter.', 'color' => 'bg-purple-50 text-purple-600'],
                ['name' => 'Business', 'icon' => 'business_center', 'desc' => 'Konsultasi hukum, pajak, dan manajemen.', 'color' => 'bg-green-50 text-green-600'],
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($categories as $cat)
            <a href="/?kategori={{ $cat['name'] }}" class="group bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md hover:border-[#003fb1] transition-all">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 {{ $cat['color'] }} rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">{{ $cat['icon'] }}</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-900">{{ $cat['name'] }}</h3>
                        <p class="text-xs text-gray-400 font-medium">{{ $kategoriCounts[$cat['name']] ?? 0 }} jasa tersedia</p>
                    </div>
                </div>
                <p class="text-sm text-gray-500">{{ $cat['desc'] }}</p>
            </a>
            @endforeach
        </div>
    </section>

    <section id="jasa" class="py-20 max-w-7xl mx-auto px-6 border-t border-gray-100">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-extrabold text-[#151c27]">Jasa Terbaru</h2>
                <p class="text-gray-500 mt-2">Solusi terbaik dari para profesional untuk Anda.</p>
            </div>
        </div>

        @forelse ($jasasByCategory as $kategori => $jasaList)
            <div class="mb-12 last:mb-0">
                <div class="flex items-center gap-3 mb-6">
                    @php
                        $catIcon = match($kategori) {
                            'Cleaning' => 'cleaning_services',
                            'Repair' => 'construction',
                            'Creative' => 'palette',
                            'Business' => 'business_center',
                            default => 'handyman'
                        };
                        $catColor = match($kategori) {
                            'Cleaning' => 'bg-blue-50 text-blue-600',
                            'Repair' => 'bg-orange-50 text-orange-600',
                            'Creative' => 'bg-purple-50 text-purple-600',
                            'Business' => 'bg-green-50 text-green-600',
                            default => 'bg-gray-50 text-gray-600'
                        };
                    @endphp
                    <div class="w-10 h-10 {{ $catColor }} rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined">{{ $catIcon }}</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-extrabold text-[#151c27]">{{ $kategori }}</h3>
                        <p class="text-xs text-gray-400 font-medium">{{ $jasaList->count() }} jasa tersedia</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($jasaList as $jasa)
                    <a href="{{ route('jasa.show', $jasa) }}" class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-[#003fb1] transition-all overflow-hidden">
                        <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                            @php $firstImg = is_array($jasa->gambar) ? ($jasa->gambar[0] ?? null) : $jasa->gambar; @endphp
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 src="{{ $firstImg ? asset('storage/jasa/' . $firstImg) : 'https://ui-avatars.com/api/?name=' . urlencode($jasa->nama_jasa) . '&background=003fb1&color=fff' }}"
                                 alt="{{ $jasa->nama_jasa }}"
                                 onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($jasa->nama_jasa) }}&background=003fb1&color=fff';">
                        </div>
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-2">
                                <span class="text-[10px] font-bold uppercase px-2.5 py-1 bg-blue-50 text-[#003fb1] rounded-lg">{{ $jasa->kategori ?? 'Service' }}</span>
                                <span class="text-sm font-bold text-green-600">Rp {{ number_format($jasa->harga, 0, ',', '.') }}</span>
                            </div>
                            <h3 class="font-bold text-lg mb-1 truncate text-gray-900">{{ $jasa->nama_jasa }}</h3>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-5 h-5 bg-gray-100 rounded-full flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[12px] text-gray-500">person</span>
                                </div>
                                <span class="text-xs text-gray-500 font-medium">{{ $jasa->user->name ?? 'Penyedia Jasa' }}</span>
                            </div>
                            <p class="text-xs text-gray-400 line-clamp-2 leading-relaxed">{{ $jasa->deskripsi }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                <span class="material-symbols-outlined text-gray-300 text-6xl mb-4">search_off</span>
                <p class="text-gray-400 font-medium">Belum ada jasa yang tersedia saat ini.</p>
            </div>
        @endforelse
    </section>

    <section class="max-w-7xl mx-auto px-6 mb-20">
        <div class="bg-[#003fb1] rounded-2xl p-12 md:p-16 text-center relative overflow-hidden text-white shadow-xl shadow-blue-100">
            <h2 class="text-3xl font-extrabold mb-4">Siap Memulai Proyek Anda?</h2>
            <p class="text-blue-200 mb-8 max-w-xl mx-auto">Gabung sekarang dan temukan kemudahan dalam mencari layanan jasa profesional.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('bookings.index') }}" class="bg-white text-[#003fb1] px-8 py-4 rounded-xl font-bold shadow-lg hover:bg-gray-50 transition-all">Lihat Booking Saya</a>
                @else
                    <a href="{{ route('register') }}" class="bg-white text-[#003fb1] px-8 py-4 rounded-xl font-bold shadow-lg hover:bg-gray-50 transition-all">Daftar Gratis</a>
                    <a href="{{ route('login') }}" class="bg-white/10 text-white border border-white/30 px-8 py-4 rounded-xl font-bold hover:bg-white/20 transition-all">Masuk</a>
                @endauth
            </div>
        </div>
    </section>
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
                    <li><a href="#kategori" class="hover:text-[#003fb1] transition-colors">Kategori</a></li>
                    <li><a href="#jasa" class="hover:text-[#003fb1] transition-colors">Jasa</a></li>
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

<nav class="md:hidden fixed bottom-0 w-full z-50 bg-white border-t border-gray-200 flex justify-around items-center h-16 px-4">
    <a class="flex flex-col items-center text-[#003fb1]" href="/">
        <span class="material-symbols-outlined">explore</span>
        <span class="text-[10px] font-bold">Beranda</span>
    </a>
    <a class="flex flex-col items-center text-gray-400" href="#kategori">
        <span class="material-symbols-outlined">category</span>
        <span class="text-[10px] font-bold">Kategori</span>
    </a>
    <a class="flex flex-col items-center text-gray-400" href="#jasa">
        <span class="material-symbols-outlined">handyman</span>
        <span class="text-[10px] font-bold">Jasa</span>
    </a>
    @auth
        <a class="flex flex-col items-center text-gray-400 relative" href="{{ route('notifications.index') }}">
            <span class="material-symbols-outlined">notifications</span>
            @php $unreadCount = Auth::user()->unreadNotifications()->count(); @endphp
            @if($unreadCount > 0)
                <span class="absolute -top-0.5 right-1 w-4 h-4 bg-red-500 text-white text-[8px] font-bold rounded-full flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
            @endif
            <span class="text-[10px] font-bold">Notif</span>
        </a>
        <a class="flex flex-col items-center text-gray-400" href="{{ Auth::user()->role === 'user' ? route('bookings.index') : route('dashboard') }}">
            <span class="material-symbols-outlined">person</span>
            <span class="text-[10px] font-bold">{{ Auth::user()->role === 'user' ? 'Booking' : 'Menu' }}</span>
        </a>
    @else
        <a class="flex flex-col items-center text-gray-400" href="{{ route('about') }}">
            <span class="material-symbols-outlined">info</span>
            <span class="text-[10px] font-bold">About</span>
        </a>
        <a class="flex flex-col items-center text-gray-400" href="{{ route('login') }}">
            <span class="material-symbols-outlined">person</span>
            <span class="text-[10px] font-bold">Akun</span>
        </a>
    @endauth
</nav>

@include('components.floating-chat')
</body>
</html>