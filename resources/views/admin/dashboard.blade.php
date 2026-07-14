<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>ServiceFlow Admin Dashboard</title>
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
        <h1 class="text-2xl font-bold text-[#003fb1]">ServiceFlow</h1>
        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Marketplace Admin</p>
    </div>
    
    <nav class="flex flex-col gap-1 flex-grow">
        <a class="flex items-center gap-3 bg-[#e7eefe] text-[#003fb1] rounded-xl px-4 py-3 font-semibold text-sm transition-all" href="{{ route('admin.users.index') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span>Dashboard</span>
        </a>
        <a class="flex items-center gap-3 text-gray-500 px-4 py-3 hover:bg-gray-50 rounded-xl transition-all text-sm font-medium" href="{{ route('admin.users.index') }}">
            <span class="material-symbols-outlined">group</span>
            <span>Manage Users</span>
        </a>
        <a class="flex items-center gap-3 text-gray-500 px-4 py-3 hover:bg-gray-50 rounded-xl transition-all text-sm font-medium" href="#">
            <span class="material-symbols-outlined">payments</span>
            <span>Earnings</span>
        </a>
        <a class="flex items-center gap-3 text-gray-500 px-4 py-3 hover:bg-gray-50 rounded-xl transition-all text-sm font-medium" href="#">
            <span class="material-symbols-outlined">handyman</span>
            <span>Services</span>
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
        <div class="flex items-center gap-4 flex-1">
            <div class="relative w-full max-w-md">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <input class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-[#003fb1] outline-none transition-all" placeholder="Search resources..." type="text"/>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 pr-4 border-r border-gray-100">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-bold text-blue-600 uppercase">{{ Auth::user()->role }}</p>
                </div>
                <img class="w-10 h-10 rounded-full object-cover border-2 border-blue-50" src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=003fb1&color=fff" alt="Profile"/>
            </div>
            <button class="p-2 rounded-xl bg-gray-50 text-gray-500 hover:bg-gray-100 transition-all">
                <span class="material-symbols-outlined">settings</span>
            </button>
        </div>
    </header>

    <main class="p-8 space-y-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-blue-50 rounded-xl">
                        <span class="material-symbols-outlined text-[#003fb1]">payments</span>
                    </div>
                    <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-lg">+12%</span>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Revenue</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1">$124,592.00</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-green-50 rounded-xl">
                        <span class="material-symbols-outlined text-green-600">group</span>
                    </div>
                    <span class="text-xs font-bold text-green-600 bg-green-100 px-2 py-1 rounded-lg">8,432</span>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Users</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1">{{ \App\Models\User::count() }}</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-orange-50 rounded-xl">
                        <span class="material-symbols-outlined text-orange-600">verified_user</span>
                    </div>
                    <span class="text-[10px] font-bold text-red-600 bg-red-50 px-2 py-1 rounded-lg">HIGH</span>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Pending Tasks</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1">42</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-purple-50 rounded-xl">
                        <span class="material-symbols-outlined text-purple-600">task_alt</span>
                    </div>
                    <span class="text-xs font-bold text-purple-600 bg-purple-100 px-2 py-1 rounded-lg">15%</span>
                </div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Growth</p>
                <h3 class="text-2xl font-extrabold text-gray-900 mt-1">Gacor</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Recent Registered Users</h2>
                        <p class="text-xs text-gray-500 font-medium mt-1">Review and manage platform members</p>
                    </div>
                    <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-[#003fb1] text-white rounded-xl text-xs font-bold shadow-lg shadow-blue-100 hover:opacity-90 transition-all">
                        + Add User
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-white border-b border-gray-50 text-[11px] uppercase text-gray-400 font-bold tracking-widest">
                            <tr>
                                <th class="px-6 py-4">User Info</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center text-[#003fb1] font-bold text-xs border border-gray-200">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900">{{ $user->name }}</p>
                                            <p class="text-[11px] text-gray-400">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase {{ $user->role == 'admin' ? 'bg-red-50 text-red-600' : 'bg-blue-50 text-blue-600' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-[12px] font-medium text-green-600 italic">Active</td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-[#003fb1] text-xs font-bold hover:underline">Edit Dossier</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-50">
                    {{ $users->links() }}
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-6">
                <h3 class="text-xl font-bold text-gray-900">Live Activities</h3>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-2 h-2 mt-2 rounded-full bg-blue-600 shrink-0 shadow-[0_0_10px_rgba(0,63,177,0.5)]"></div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">New Admin Action</p>
                            <p class="text-xs text-gray-500 leading-relaxed">System updated user permissions for vendor accounts.</p>
                            <p class="text-[10px] text-gray-300 font-bold mt-2 uppercase tracking-tighter">Just Now</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="w-2 h-2 mt-2 rounded-full bg-green-500 shrink-0"></div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Database Backup</p>
                            <p class="text-xs text-gray-500 leading-relaxed">Daily cloud backup completed successfully.</p>
                            <p class="text-[10px] text-gray-300 font-bold mt-2 uppercase tracking-tighter">15 Mins Ago</p>
                        </div>
                    </div>
                </div>
                <button class="w-full py-3 bg-gray-50 rounded-xl text-xs font-bold text-gray-500 hover:bg-gray-100 transition-all">View All Audit Logs</button>
            </div>
        </div>
    </main>
</div>

<nav class="lg:hidden fixed bottom-0 left-0 right-0 h-16 bg-white border-t border-gray-100 z-50 flex justify-around items-center">
    <a class="flex flex-col items-center text-[#003fb1]" href="#">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="text-[10px] font-bold">Dash</span>
    </a>
    <a class="flex flex-col items-center text-gray-400" href="{{ route('admin.users.index') }}">
        <span class="material-symbols-outlined">group</span>
        <span class="text-[10px] font-bold">Users</span>
    </a>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="flex flex-col items-center text-red-400">
            <span class="material-symbols-outlined">logout</span>
            <span class="text-[10px] font-bold">Out</span>
        </button>
    </form>
</nav>

</body>
</html>