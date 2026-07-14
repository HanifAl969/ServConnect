<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'ServeConnect — Vendor')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-[#f9f9ff] text-[#151c27] antialiased overflow-x-hidden">

<aside class="hidden lg:flex flex-col h-screen border-r border-gray-200 p-6 gap-8 fixed left-0 w-64 bg-white z-40">
    <div class="flex flex-col gap-1 mb-4">
        <h1 class="text-2xl font-bold text-[#003fb1]">ServeConnect</h1>
        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Vendor Panel</p>
    </div>

    <nav class="flex flex-col gap-1 flex-grow">
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-[#e7eefe] text-[#003fb1] font-semibold' : 'text-gray-500 hover:bg-gray-50' }}" href="{{ route('dashboard') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('vendor.bookings') ? 'bg-[#e7eefe] text-[#003fb1] font-semibold' : 'text-gray-500 hover:bg-gray-50' }}" href="{{ route('vendor.bookings') }}">
            <span class="material-symbols-outlined">receipt_long</span>
            <span>Booking Masuk</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('vendor.talent') ? 'bg-[#e7eefe] text-[#003fb1] font-semibold' : 'text-gray-500 hover:bg-gray-50' }}" href="{{ route('vendor.talent') }}">
            <span class="material-symbols-outlined">badge</span>
            <span>Agent Saya</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('vendor.chat') ? 'bg-[#e7eefe] text-[#003fb1] font-semibold' : 'text-gray-500 hover:bg-gray-50' }}" href="{{ route('vendor.chat') }}">
            <span class="material-symbols-outlined">smart_toy</span>
            <span>Chatbot AI</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('notifications.*') ? 'bg-[#e7eefe] text-[#003fb1] font-semibold' : 'text-gray-500 hover:bg-gray-50' }}" href="{{ route('notifications.index') }}">
            <span class="material-symbols-outlined">notifications</span>
            <span>Notifikasi</span>
        </a>
        <a class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all text-sm font-medium {{ request()->routeIs('profile.edit') ? 'bg-[#e7eefe] text-[#003fb1] font-semibold' : 'text-gray-500 hover:bg-gray-50' }}" href="{{ route('profile.edit') }}">
            <span class="material-symbols-outlined">settings</span>
            <span>Pengaturan</span>
        </a>
    </nav>

    <div class="mt-auto flex flex-col gap-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left flex items-center gap-3 text-red-500 px-4 py-3 hover:bg-red-50 rounded-xl transition-all font-semibold text-sm">
                <span class="material-symbols-outlined">logout</span>
                <span>Logout</span>
            </button>
        </form>
    </div>
</aside>

<div class="lg:ml-64 flex flex-col min-h-screen">
    <header class="flex justify-between items-center h-20 px-8 w-full sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="flex flex-col">
            <h2 class="text-xl font-bold text-gray-900">@yield('header')</h2>
            <p class="text-xs text-gray-400 font-medium hidden sm:block">@yield('subheader')</p>
        </div>

        <div class="flex items-center gap-4">
            <div class="relative" x-data="{ open: false }">
                <a href="{{ route('notifications.index') }}" class="relative p-2 hover:bg-gray-50 rounded-xl transition-all">
                    <span class="material-symbols-outlined text-gray-500">notifications</span>
                    @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                    @if($unread > 0)
                        <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $unread > 9 ? '9+' : $unread }}</span>
                    @endif
                </a>
            </div>

            <div class="flex items-center gap-2 pl-4 border-l border-gray-100">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-bold text-green-600 uppercase">{{ Auth::user()->status ?? 'active' }}</p>
                </div>
                <img class="w-10 h-10 rounded-full object-cover border-2 border-green-50" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=003fb1&color=fff" alt="Profile"/>
            </div>
        </div>
    </header>

    <main class="p-8">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>
</div>

<nav class="lg:hidden fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-gray-100 z-50 flex justify-around items-center">
    <a class="flex flex-col items-center {{ request()->routeIs('dashboard') ? 'text-[#003fb1]' : 'text-gray-400' }}" href="{{ route('dashboard') }}">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="text-[10px] font-bold">Dashboard</span>
    </a>
    <a class="flex flex-col items-center {{ request()->routeIs('vendor.bookings') ? 'text-[#003fb1]' : 'text-gray-400' }}" href="{{ route('vendor.bookings') }}">
        <span class="material-symbols-outlined">receipt_long</span>
        <span class="text-[10px] font-bold">Booking</span>
    </a>
    <a class="flex flex-col items-center {{ request()->routeIs('vendor.talent') ? 'text-[#003fb1]' : 'text-gray-400' }}" href="{{ route('vendor.talent') }}">
        <span class="material-symbols-outlined">badge</span>
        <span class="text-[10px] font-bold">Agent</span>
    </a>
    <a class="flex flex-col items-center {{ request()->routeIs('vendor.chat') ? 'text-[#003fb1]' : 'text-gray-400' }}" href="{{ route('vendor.chat') }}">
        <span class="material-symbols-outlined">smart_toy</span>
        <span class="text-[10px] font-bold">Chat</span>
    </a>
    <a class="flex flex-col items-center {{ request()->routeIs('notifications.*') ? 'text-[#003fb1]' : 'text-gray-400' }}" href="{{ route('notifications.index') }}">
        <span class="material-symbols-outlined">notifications</span>
        <span class="text-[10px] font-bold">Notif</span>
    </a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="flex flex-col items-center text-red-400">
            <span class="material-symbols-outlined">logout</span>
            <span class="text-[10px] font-bold">Keluar</span>
        </button>
    </form>
</nav>

@include('components.floating-chat')
</body>
</html>