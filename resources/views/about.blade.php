<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tentang Kami — ServeConnect</title>
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
            <a class="text-gray-600 hover:text-[#003fb1] transition-colors text-sm font-semibold" href="/#kategori">Kategori</a>
            <a class="text-gray-600 hover:text-[#003fb1] transition-colors text-sm font-semibold" href="/#jasa">Jasa</a>
            <a class="text-[#003fb1] font-bold transition-colors text-sm" href="{{ route('about') }}">Tentang Kami</a>
        </div>

        <div class="flex items-center gap-3">
            @auth
                <div class="relative" x-data="{ open: false }">
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

<main>
    <section class="pt-28 pb-16 max-w-7xl mx-auto px-6">
        <div class="max-w-3xl mx-auto text-center mb-16">
            <span class="inline-block px-3 py-1.5 bg-blue-50 text-[#003fb1] rounded-lg text-xs font-bold uppercase tracking-wider mb-4">Tentang Kami</span>
            <h1 class="text-4xl font-extrabold text-[#151c27] mb-6">Platform Jasa Profesional Terpercaya di Indonesia</h1>
            <p class="text-lg text-gray-600">ServeConnect hadir untuk menghubungkan Anda dengan penyedia jasa terbaik di berbagai bidang, dari kebersihan hingga konsultasi bisnis.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
                <div class="w-14 h-14 bg-blue-50 text-[#003fb1] rounded-xl flex items-center justify-center mx-auto mb-5">
                    <span class="material-symbols-outlined">groups</span>
                </div>
                <h3 class="font-bold text-lg mb-2">Vendor Terverifikasi</h3>
                <p class="text-sm text-gray-500">Setiap vendor melalui proses verifikasi ketat untuk menjamin kualitas layanan.</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
                <div class="w-14 h-14 bg-green-50 text-green-600 rounded-xl flex items-center justify-center mx-auto mb-5">
                    <span class="material-symbols-outlined">verified</span>
                </div>
                <h3 class="font-bold text-lg mb-2">Jaminan Kualitas</h3>
                <p class="text-sm text-gray-500">Setiap jasa memiliki ulasan dan rating dari pelanggan sebelumnya.</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
                <div class="w-14 h-14 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center mx-auto mb-5">
                    <span class="material-symbols-outlined">support_agent</span>
                </div>
                <h3 class="font-bold text-lg mb-2">Dukungan 24/7</h3>
                <p class="text-sm text-gray-500">Tim support siap membantu Anda kapan pun melalui chatbot dan notifikasi.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 md:p-14 mb-20">
            <h2 class="text-2xl font-extrabold text-[#151c27] mb-6">Misi Kami</h2>
            <p class="text-gray-600 mb-4 leading-relaxed">ServeConnect bertujuan untuk menjadi platform utama dalam menghubungkan pelanggan dengan penyedia jasa profesional di Indonesia. Kami percaya bahwa setiap orang berhak mendapatkan layanan berkualitas dengan proses yang mudah, transparan, dan terpercaya.</p>
            <p class="text-gray-600 leading-relaxed">Dengan teknologi modern dan sistem verifikasi yang ketat, kami memastikan setiap transaksi berjalan aman dan memuaskan bagi kedua belah pihak.</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6 mb-20">
        <div class="bg-[#003fb1] rounded-2xl p-12 md:p-16 text-center relative overflow-hidden text-white shadow-xl shadow-blue-100">
            <h2 class="text-3xl font-extrabold mb-4">Siap Bergabung?</h2>
            <p class="text-blue-200 mb-8 max-w-xl mx-auto">Temukan jasa profesional atau daftarkan layanan Anda sekarang.</p>
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

<nav class="md:hidden fixed bottom-0 w-full z-50 bg-white border-t border-gray-200 flex justify-around items-center h-16 px-4">
    <a class="flex flex-col items-center text-[#003fb1]" href="/">
        <span class="material-symbols-outlined">explore</span>
        <span class="text-[10px] font-bold">Beranda</span>
    </a>
    <a class="flex flex-col items-center text-gray-400" href="/#kategori">
        <span class="material-symbols-outlined">category</span>
        <span class="text-[10px] font-bold">Kategori</span>
    </a>
    <a class="flex flex-col items-center text-gray-400" href="/#jasa">
        <span class="material-symbols-outlined">handyman</span>
        <span class="text-[10px] font-bold">Jasa</span>
    </a>
    @auth
        <a class="flex flex-col items-center text-gray-400" href="{{ route('notifications.index') }}">
            <span class="material-symbols-outlined">notifications</span>
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

<script>
function toggleDropdown() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('hidden');
}
document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('userDropdown');
    const button = dropdown.previousElementSibling;
    if (!button.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.classList.add('hidden');
    }
});
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        document.getElementById('userDropdown').classList.add('hidden');
    }
});
</script>

</body>
</html>
