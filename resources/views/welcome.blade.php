<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Serve Connect | Temukan Solusi Profesional</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        :root {
            --primary: #003fb1;
            --primary-container: #1a56db;
            --background: #f9f9ff;
        }
    </style>
</head>
<body class="bg-[#f9f9ff] text-[#151c27] selection:bg-[#1a56db] selection:text-white">

    <nav class="fixed top-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm antialiased">
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="/" class="text-xl font-bold tracking-tight text-blue-700">ServeConnect</a>
                <div class="hidden md:flex items-center gap-6">
                    <a class="text-blue-700 border-b-2 border-blue-700 pb-1 text-sm font-semibold" href="#">Explore</a>
                    <a class="text-gray-600 hover:text-blue-600 transition-colors text-sm font-semibold" href="#">Categories</a>
                    <a class="text-gray-600 hover:text-blue-600 transition-colors text-sm font-semibold" href="#">How it Works</a>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @if (Route::has('login'))
                    @auth
                        <div class="flex items-center gap-3 mr-2">
                            <span class="hidden sm:inline-block text-sm font-medium text-gray-700">Halo, {{ Auth::user()->name }}</span>
                        </div>

                        @if(Auth::user()->role !== 'user')
                            <a href="{{ url('/dashboard') }}" class="text-blue-600 hover:bg-blue-50 font-semibold text-sm px-4 py-2 rounded-lg transition">Dashboard</a>
                        @endif

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-bold px-4 py-2 transition">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-semibold text-sm px-4 py-2 transition">Sign In</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-blue-600 text-white hover:bg-blue-700 transition-all active:scale-95 px-6 py-2.5 rounded-lg font-semibold text-sm shadow-md shadow-blue-200">
                                Join Now
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <main class="pt-16 pb-24 md:pb-0">
        <section class="relative min-h-[600px] flex items-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img class="w-full h-full object-cover opacity-15 grayscale-[0.5]" src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80" alt="Office Background"/>
                <div class="absolute inset-0 bg-gradient-to-tr from-white via-white/80 to-transparent"></div>
            </div>
            
            <div class="max-w-7xl mx-auto px-6 relative z-10 w-full">
                <div class="max-w-2xl">
                    <h1 class="text-5xl font-bold text-[#151c27] mb-6 leading-tight font-manrope">
                        Temukan Solusi Profesional untuk Setiap Kebutuhan Anda
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 max-w-lg font-inter">
                        Platform terpercaya untuk menghubungkan Anda dengan penyedia jasa ahli dalam hitungan menit.
                    </p>

                    <div class="bg-white p-2 rounded-xl shadow-xl border border-gray-100 flex flex-col md:flex-row items-center gap-2 max-w-3xl">
                        <div class="flex items-center gap-3 px-4 py-3 w-full border-b md:border-b-0 md:border-r border-gray-100">
                            <span class="material-symbols-outlined text-gray-400">search</span>
                            <input class="w-full border-none focus:ring-0 text-sm text-[#151c27] p-0" placeholder="Jasa apa yang Anda butuhkan?" type="text"/>
                        </div>
                        <div class="flex items-center gap-3 px-4 py-3 w-full md:w-auto min-w-[200px]">
                            <span class="material-symbols-outlined text-gray-400">location_on</span>
                            <input class="w-full border-none focus:ring-0 text-sm text-[#151c27] p-0" placeholder="Lokasi Anda" type="text"/>
                        </div>
                        <button class="w-full md:w-auto bg-[#003fb1] text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition-colors">
                            Cari
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-[#151c27]">Kategori Populer</h2>
                    <p class="text-gray-500 mt-2">Jelajahi ribuan layanan dari ahli di bidangnya.</p>
                </div>
                <a class="text-blue-700 font-semibold flex items-center gap-2 hover:underline" href="#">
                    Lihat Semua <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $categories = [
                        ['name' => 'Cleaning', 'icon' => 'cleaning_services', 'desc' => 'Kebersihan rumah, kantor, hingga laundry.', 'img' => 'https://images.unsplash.com/photo-1581578731548-c64695cc6958?auto=format&fit=crop&q=80'],
                        ['name' => 'Repair', 'icon' => 'construction', 'desc' => 'Perbaikan listrik, AC, hingga renovasi.', 'img' => 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?auto=format&fit=crop&q=80'],
                        ['name' => 'Creative', 'icon' => 'palette', 'desc' => 'Desain grafis, fotografi, hingga copywriter.', 'img' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&q=80'],
                        ['name' => 'Business', 'icon' => 'business_center', 'desc' => 'Konsultasi hukum, pajak, dan manajemen.', 'img' => 'https://images.unsplash.com/photo-1454165833762-02652d578941?auto=format&fit=crop&q=80'],
                    ];
                @endphp

                @foreach ($categories as $cat)
                <div class="group relative overflow-hidden rounded-xl border border-gray-200 bg-white hover:border-blue-600 transition-all duration-300 shadow-sm hover:shadow-md">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $cat['img'] }}" alt="{{ $cat['name'] }}"/>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="material-symbols-outlined text-blue-700">{{ $cat['icon'] }}</span>
                            <h3 class="font-bold text-lg">{{ $cat['name'] }}</h3>
                        </div>
                        <p class="text-sm text-gray-500">{{ $cat['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <section class="py-20 max-w-7xl mx-auto px-6 border-t border-gray-100">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-[#151c27]">Jasa Terbaru</h2>
                    <p class="text-gray-500 mt-2">Solusi terbaik dari para profesional untuk Anda.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse ($jasas as $jasa)
                <div class="group relative overflow-hidden rounded-xl border border-gray-200 bg-white hover:border-blue-600 transition-all duration-300 shadow-sm hover:shadow-md">
                    
                    <div class="aspect-[4/3] overflow-hidden bg-gray-100 flex items-center justify-center relative">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                        src="{{ asset('storage/jasa/' . $jasa->gambar) }}" 
                        alt="{{ $jasa->nama_jasa }}"
                        onerror="this.onerror=null; this.src='{{ asset('public/storage/jasa/' . $jasa->gambar) }}'; this.onfailed=function(){ this.src='https://ui-avatars.com/api/?name={{ urlencode($jasa->nama_jasa) }}&background=003fb1&color=fff'; };">
                    </div>

                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-[10px] font-bold uppercase px-2 py-1 bg-blue-50 text-blue-700 rounded">{{ $jasa->category->nama_kategori ?? $jasa->kategori ?? 'Service' }}</span>
                            <span class="text-sm font-bold text-green-600">Rp{{ number_format($jasa->harga, 0, ',', '.') }}</span>
                        </div>
                        <h3 class="font-bold text-lg mb-1 truncate">{{ $jasa->nama_jasa }}</h3>
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-[12px] text-blue-600">person</span>
                            </div>
                            <span class="text-xs text-gray-600 font-medium">{{ $jasa->user->name ?? 'Penyedia Jasa' }}</span>
                        </div>
                        <p class="text-xs text-gray-500 line-clamp-2 italic leading-relaxed">{{ $jasa->deskripsi ?? 'Deskripsi layanan jasa terbaik untuk penuhi segala kebutuhan event spesial Anda.' }}</p>
                    </div>
                </div>
                @empty
                    <div class="col-span-full text-center py-20 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <span class="material-symbols-outlined text-gray-300 text-6xl mb-4">search_off</span>
                        <p class="text-gray-400 font-medium">Belum ada jasa yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </section>

        <section class="max-w-7xl mx-auto px-6 mb-20">
            <div class="bg-blue-700 rounded-2xl p-12 text-center relative overflow-hidden text-white shadow-xl shadow-blue-100">
                <h2 class="text-3xl font-bold mb-4">Siap Memulai Proyek Anda?</h2>
                <p class="text-blue-100 mb-8 max-w-xl mx-auto">Gabung sekarang dan temukan kemudahan dalam mencari layanan jasa profesional.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="#" class="bg-white text-blue-700 px-8 py-4 rounded-lg font-bold shadow-lg hover:bg-gray-50 transition-colors">Cari Jasa Sekarang</a>
                    @else
                        <a href="{{ route('register') }}" class="bg-white text-blue-700 px-8 py-4 rounded-lg font-bold shadow-lg hover:bg-gray-50 transition-colors">Daftar Gratis</a>
                    @endauth
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-white border-t border-gray-200 w-full py-12">
        <div class="max-w-7xl mx-auto px-6 text-center md:text-left">
            <span class="text-lg font-bold text-blue-700 block mb-2">ServeConnect</span>
            <p class="text-gray-500 text-sm">© 2024 ServeConnect. Solusi jasa terpercaya Anda.</p>
        </div>
    </footer>

    <nav class="md:hidden fixed bottom-0 w-full z-50 bg-white border-t border-gray-200 flex justify-around items-center h-16 px-4">
        <a class="flex flex-col items-center text-blue-700" href="#"><span class="material-symbols-outlined">explore</span><span class="text-[10px]">Explore</span></a>
        <a class="flex flex-col items-center text-gray-400" href="#"><span class="material-symbols-outlined">search</span><span class="text-[10px]">Search</span></a>
        <a class="flex flex-col items-center text-gray-400" href="{{ route('login') }}"><span class="material-symbols-outlined">person</span><span class="text-[10px]">Account</span></a>
    </nav>

</body>
</html>