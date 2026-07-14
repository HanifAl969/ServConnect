<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'ServeConnect')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Manrope', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24; }
    </style>
</head>
<body class="bg-[#f9f9ff] text-[#151c27] antialiased">

<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
        <div class="flex items-center gap-8">
            <a href="/" class="text-xl font-bold tracking-tight text-[#003fb1]">ServeConnect</a>
            <div class="hidden md:flex items-center gap-6">
                <a href="/" class="text-sm font-semibold text-gray-600 hover:text-[#003fb1] transition-colors">Beranda</a>
                <a href="{{ route('bookings.index') }}" class="text-sm font-semibold text-gray-600 hover:text-[#003fb1] transition-colors">Booking</a>
                <a href="{{ route('notifications.index') }}" class="text-sm font-semibold text-gray-600 hover:text-[#003fb1] transition-colors">Notifikasi</a>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('notifications.index') }}" class="relative p-2 hover:bg-gray-50 rounded-xl transition-all md:hidden">
                <span class="material-symbols-outlined text-gray-500">notifications</span>
                @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                @if($unread > 0)
                    <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $unread > 9 ? '9+' : $unread }}</span>
                @endif
            </a>
            <div class="flex items-center gap-2 pl-3 border-l border-gray-200">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-bold text-blue-600 uppercase">User</p>
                </div>
                <img class="w-9 h-9 rounded-full object-cover border-2 border-blue-50" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=003fb1&color=fff" alt="Profile"/>
                <form method="POST" action="{{ route('logout') }}" class="inline ml-2">
                    @csrf
                    <button type="submit" class="text-sm font-bold text-red-500 hover:text-red-700 transition">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>

<header class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <h2 class="text-xl font-bold text-gray-900">@yield('header')</h2>
            <p class="text-xs text-gray-400 font-medium hidden sm:block">@yield('subheader')</p>
        </div>
        <a href="{{ route('notifications.index') }}" class="relative p-2 hover:bg-gray-50 rounded-xl transition-all hidden md:block">
            <span class="material-symbols-outlined text-gray-500">notifications</span>
            @php $unread = auth()->user()->unreadNotifications->count(); @endphp
            @if($unread > 0)
                <span class="absolute -top-0.5 -right-0.5 w-5 h-5 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ $unread > 9 ? '9+' : $unread }}</span>
            @endif
        </a>
    </div>
</header>

<main class="max-w-7xl mx-auto px-6 py-8">
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

@stack('scripts')

@include('components.floating-chat')
</body>
</html>