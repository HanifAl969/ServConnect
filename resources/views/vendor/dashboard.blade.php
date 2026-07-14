<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Jasa Connect - Vendor Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght=400;600;700;800&family=Inter:wght=400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, .brand-font { font-family: 'Manrope', sans-serif; }
    </style>
</head>
<body class="bg-[#f9f9ff] text-[#151c27]">

    <aside class="hidden lg:flex flex-col h-screen border-r border-gray-200 bg-white p-6 gap-8 fixed left-0 w-64 z-50">
        <div class="flex items-center gap-3 px-2">
            <div class="w-10 h-10 rounded-lg bg-[#003fb1] flex items-center justify-center">
                <span class="material-symbols-outlined text-white">token</span>
            </div>
            <div>
                <p class="font-bold text-[#003fb1] leading-tight">ServiceFlow</p>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider">Vendor Panel</p>
            </div>
        </div>

        <nav class="flex flex-col gap-1">
            <a class="flex items-center gap-3 bg-[#e7eefe] text-[#003fb1] rounded-xl px-4 py-3 font-semibold text-sm" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined">dashboard</span> Dashboard
            </a>
            <a class="flex items-center gap-3 text-gray-500 hover:bg-gray-50 rounded-xl px-4 py-3 text-sm transition-all" href="#">
                <span class="material-symbols-outlined">calendar_today</span> Bookings
            </a>
            <a class="flex items-center gap-3 text-gray-500 hover:bg-gray-50 rounded-xl px-4 py-3 text-sm transition-all" href="#">
                <span class="material-symbols-outlined">payments</span> Earnings
            </a>
            <a class="flex items-center gap-3 text-gray-500 hover:bg-gray-50 rounded-xl px-4 py-3 text-sm transition-all" href="{{ route('profile.edit') }}">
                <span class="material-symbols-outlined">settings</span> Settings
            </a>
        </nav>

        <div class="mt-auto pt-6 border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 text-red-500 px-4 py-3 rounded-xl hover:bg-red-50 transition-all font-semibold text-sm">
                    <span class="material-symbols-outlined">logout</span> Logout
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 lg:ml-64 p-6 lg:p-10">

        <header class="lg:hidden flex justify-between items-center mb-8">
            <span class="font-bold text-[#003fb1] text-xl">ServiceFlow</span>
            <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden border">
                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" alt="Profile">
            </div>
        </header>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3 text-sm font-semibold">
                <span class="material-symbols-outlined text-green-600">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Overview</h1>
                <p class="text-gray-500 mt-2 font-medium">Welcome back, {{ Auth::user()->name }}! Here's your performance today.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('vendor.jasa.create') }}" class="px-6 py-3 bg-[#003fb1] text-white rounded-xl font-bold text-sm flex items-center gap-2 shadow-lg shadow-blue-200 hover:opacity-90 transition-all">
                    <span class="material-symbols-outlined text-[20px]">add</span> Add New Service
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-50 text-green-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <span class="text-green-600 text-xs font-bold bg-green-100 px-2 py-1 rounded-full">+12%</span>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Earnings</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">Rp 0</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined">handyman</span>
                    </div>
                    <span class="text-blue-600 text-xs font-bold bg-blue-100 px-2 py-1 rounded-full">Active</span>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Active Services</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $jasas->count() }} Jasa</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined">visibility</span>
                    </div>
                    <span class="text-orange-600 text-xs font-bold bg-orange-100 px-2 py-1 rounded-full">High</span>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Profile Views</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">1,204</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined">star</span>
                    </div>
                    <span class="text-purple-600 text-xs font-bold bg-purple-100 px-2 py-1 rounded-full">Top 5%</span>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Average Rating</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">4.9/5.0</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
                    <h2 class="text-xl font-bold text-gray-900">Your Services</h2>
                    <a href="#" class="text-[#003fb1] text-sm font-bold hover:underline">View All</a>
                </div>

                <div class="divide-y divide-gray-50">
                    @forelse($jasas as $jasa)
                    <div class="p-6 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-gray-50 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-gray-100 overflow-hidden border border-gray-200 shadow-sm flex items-center justify-center flex-shrink-0">
                                <img src="{{ asset('storage/jasa/' . $jasa->gambar) }}" 
                                     class="w-full h-full object-cover" 
                                     alt="{{ $jasa->nama_jasa }}"
                                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($jasa->nama_jasa) }}&background=003fb1&color=fff';">
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ $jasa->nama_jasa }}</p>
                                <p class="text-xs text-blue-600 font-bold bg-blue-50 px-2 py-[2px] rounded inline-block mt-1">
                                    Rp {{ number_format($jasa->harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="px-4 py-2 border border-gray-200 text-gray-600 rounded-xl font-bold text-xs hover:bg-white hover:border-blue-600 transition-all">Edit</button>
                            <button class="px-4 py-2 bg-gray-50 text-gray-400 rounded-xl font-bold text-xs cursor-not-allowed">Stats</button>
                        </div>
                    </div>
                    @empty
                    <div class="p-16 text-center">
                        <span class="material-symbols-outlined text-gray-200 text-6xl mb-4 block">inventory_2</span>
                        <p class="text-gray-400 font-medium italic">No services listed yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                    <h2 class="text-xl font-bold text-gray-900 mb-6 font-display">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="{{ route('vendor.jasa.create') }}" class="flex items-center gap-4 p-4 bg-gray-50 border border-gray-100 rounded-xl hover:border-[#003fb1] hover:bg-[#e7eefe] transition-all group">
                            <div class="w-10 h-10 bg-[#003fb1] text-white rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined">add_circle</span>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-900">Add Service</p>
                                <p class="text-[11px] text-gray-400">Post a new job listing</p>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="bg-[#003fb1] rounded-2xl p-6 relative overflow-hidden group">
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">verified</span>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-blue-200">Pro Member</span>
                        </div>
                        <h4 class="font-bold text-white text-lg leading-tight mb-4">Unlock premium badges and priority search ranking.</h4>
                        <button class="px-5 py-2.5 bg-white text-[#003fb1] rounded-xl font-bold text-xs hover:bg-blue-50 transition-all">Upgrade Now</button>
                    </div>
                    <span class="material-symbols-outlined absolute -bottom-4 -right-4 text-[120px] opacity-10 text-white group-hover:rotate-12 transition-all">workspace_premium</span>
                </div>
            </div>
        </div>
    </main>

    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 flex justify-around items-center h-16 z-50 px-4">
        <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-[#003fb1]">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-[10px] font-bold">Overview</span>
        </a>
        <a href="#" class="flex flex-col items-center text-gray-400">
            <span class="material-symbols-outlined">calendar_today</span>
            <span class="text-[10px] font-bold">Bookings</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="flex flex-col items-center text-gray-400">
            <span class="material-symbols-outlined">person</span>
            <span class="text-[10px] font-bold">Profile</span>
        </a>
    </nav>
</body>
</html>