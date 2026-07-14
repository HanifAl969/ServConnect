<div>
    <h2 class="text-lg font-bold text-gray-900">Informasi Profil</h2>
    <p class="text-sm text-gray-500 mt-1">Perbarui informasi akun dan alamat email Anda.</p>
</div>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-5">
    @csrf
    @method('patch')

    <div>
        <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Nama</label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm">
        @error('name')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm">
        @error('email')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
        @enderror

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-3">
                <p class="text-sm text-gray-600">
                    Alamat email Anda belum diverifikasi.
                    <button form="send-verification" class="underline text-sm text-[#003fb1] hover:text-blue-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#003fb1]">
                        Klik di sini untuk mengirim ulang verifikasi.
                    </button>
                </p>
                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600">
                        Tautan verifikasi baru telah dikirim ke email Anda.
                    </p>
                @endif
            </div>
        @endif
    </div>

    <div class="flex items-center gap-4 pt-2">
        <button type="submit" class="px-6 py-3 bg-[#003fb1] text-white rounded-xl text-sm font-bold hover:opacity-90 transition-all shadow-lg shadow-blue-100">
            Simpan
        </button>
        @if (session('status') === 'profile-updated')
            <p class="text-sm text-green-600 font-medium">Tersimpan.</p>
        @endif
    </div>
</form>
