@extends('layouts.admin')

@section('title', 'Dashboard Admin — ServeConnect')

@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <a href="{{ route('admin.users.index') }}" class="block bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-blue-200 transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-blue-50 rounded-xl group-hover:bg-blue-100 transition-colors">
                <span class="material-symbols-outlined text-[#003fb1]">group</span>
            </div>
        </div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total User</p>
        <h3 class="text-2xl font-extrabold text-gray-900 mt-1">{{ \App\Models\User::count() }}</h3>
    </a>

    <a href="{{ route('admin.vendor.verification') }}" class="block bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-green-200 transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-green-50 rounded-xl group-hover:bg-green-100 transition-colors">
                <span class="material-symbols-outlined text-green-600">group_work</span>
            </div>
        </div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Vendor</p>
        <h3 class="text-2xl font-extrabold text-gray-900 mt-1">{{ \App\Models\User::where('role', 'vendor')->count() }}</h3>
    </a>

    <a href="{{ route('admin.vendor.verification') }}" class="block bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-orange-200 transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-orange-50 rounded-xl group-hover:bg-orange-100 transition-colors">
                <span class="material-symbols-outlined text-orange-600">verified_user</span>
            </div>
        </div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Vendor Menunggu</p>
        <h3 class="text-2xl font-extrabold text-gray-900 mt-1">{{ \App\Models\User::where('role', 'vendor')->where('status', 'pending')->count() }}</h3>
    </a>

    <a href="{{ route('admin.user.verification') }}" class="block bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-amber-200 transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-amber-50 rounded-xl group-hover:bg-amber-100 transition-colors">
                <span class="material-symbols-outlined text-amber-600">badge</span>
            </div>
        </div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">User Menunggu KTP</p>
        <h3 class="text-2xl font-extrabold text-gray-900 mt-1">{{ \App\Models\User::where('role', 'user')->where('status', 'pending')->count() }}</h3>
    </a>

    <a href="{{ route('admin.bookings') }}" class="block bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-purple-200 transition-all group">
        <div class="flex justify-between items-start mb-4">
            <div class="p-3 bg-purple-50 rounded-xl group-hover:bg-purple-100 transition-colors">
                <span class="material-symbols-outlined text-purple-600">receipt_long</span>
            </div>
        </div>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Booking</p>
        <h3 class="text-2xl font-extrabold text-gray-900 mt-1">{{ \App\Models\Booking::count() }}</h3>
    </a>
</div>

<div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
    <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
            <div>
                <h2 class="text-xl font-bold text-gray-900">User Terbaru</h2>
                <p class="text-xs text-gray-500 font-medium mt-1">Kelola seluruh pengguna platform</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-[#003fb1] text-white rounded-xl text-xs font-bold shadow-lg shadow-blue-100 hover:opacity-90 transition-all">
                + Tambah User
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-white border-b border-gray-50 text-[11px] uppercase text-gray-400 font-bold tracking-widest">
                    <tr>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Aksi</th>
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
                            <span class="px-2 py-1 rounded-md text-[10px] font-bold uppercase {{ $user->role == 'admin' ? 'bg-red-50 text-red-600' : ($user->role == 'vendor' ? 'bg-green-50 text-green-600' : 'bg-blue-50 text-blue-600') }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-[12px] font-medium {{ $user->status == 'active' ? 'text-green-600' : ($user->status == 'pending' ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-[#003fb1] text-xs font-bold hover:underline">Edit</a>
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
        <h3 class="text-xl font-bold text-gray-900">Notifikasi Terbaru</h3>
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
        <a href="{{ route('notifications.index') }}" class="block w-full py-3 bg-gray-50 rounded-xl text-xs font-bold text-gray-500 hover:bg-gray-100 transition-all text-center">
            Lihat Semua Notifikasi
        </a>
    </div>
</div>
@endsection
