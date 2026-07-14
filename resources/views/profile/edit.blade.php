@php
    $layout = Auth::user()->role === 'admin' ? 'layouts.admin' : (Auth::user()->role === 'vendor' ? 'layouts.vendor' : 'layouts.user');
@endphp
@extends($layout)

@section('header', 'Profile')
@section('subheader', 'Kelola informasi akun Anda')

@section('content')
    <div class="max-w-3xl mx-auto space-y-6">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#003fb1] transition-colors">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Kembali ke Dashboard
        </a>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@endsection