@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : (Auth::user()->role === 'vendor' ? 'layouts.vendor' : 'layouts.user'))

@section('title', 'Booking Jasa — ServeConnect')

@section('header', 'Booking Jasa')

@section('content')
<a href="{{ route('jasa.show', $jasa) }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#003fb1] mb-6 transition-colors">
    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
    Kembali ke Detail Jasa
</a>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Form Column --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            {{-- Jasa Header --}}
            <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-gray-100 overflow-hidden border border-gray-200 flex-shrink-0">
                    @php $firstImg = is_array($jasa->gambar) ? ($jasa->gambar[0] ?? null) : $jasa->gambar; @endphp
                    <img class="w-full h-full object-cover"
                         src="{{ $firstImg ? asset('storage/jasa/' . $firstImg) : 'https://ui-avatars.com/api/?name=' . urlencode($jasa->nama_jasa) . '&background=003fb1&color=fff' }}"
                         alt="{{ $jasa->nama_jasa }}"
                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($jasa->nama_jasa) }}&background=003fb1&color=fff';">
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $jasa->nama_jasa }}</h2>
                    <div class="flex items-center gap-3 mt-1 text-sm text-gray-500">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">person</span>
                            {{ $jasa->user->name }}
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">category</span>
                            {{ $jasa->kategori }}
                        </span>
                    </div>
                </div>
            </div>

            <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm" class="p-6 space-y-8" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="jasa_id" value="{{ $jasa->id }}">

                {{-- Section 0: Pilih Talent --}}
                <div>
                    <div class="flex items-center gap-2 mb-5">
                        <span class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center">
                            <span class="material-symbols-outlined text-amber-600 text-[18px]">handyman</span>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">Pilih Talent</h3>
                            <p class="text-xs text-gray-400">Pilih penyedia jasa untuk layanan {{ $jasa->kategori }}</p>
                        </div>
                    </div>

                    <input type="hidden" name="vendor_id" id="vendor_id" value="{{ old('vendor_id', $vendor->id ?? '') }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($agents as $agent)
                            @php
                                $accepted = $agent->bookings_accepted_count ?? 0;
                                $isSelected = (old('vendor_id') == $agent->id) || (isset($vendor) && $vendor->id == $agent->id);
                            @endphp
                            <label class="agent-card relative cursor-pointer rounded-xl border-2 p-4 transition-all hover:border-gray-300
                                {{ $isSelected ? 'border-[#003fb1] bg-blue-50' : 'border-gray-100 bg-white' }}"
                                data-agent-id="{{ $agent->id }}">
                                <input type="radio" name="radio_vendor" value="{{ $agent->id }}"
                                    class="sr-only" {{ $isSelected ? 'checked' : '' }}>
                                <div class="flex items-center gap-4">
                                    <img class="w-14 h-14 rounded-full object-cover border-2 border-white shrink-0"
                                         src="https://i.pravatar.cc/200?u={{ $agent->email }}"
                                         alt="{{ $agent->name }}">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <p class="font-bold text-gray-900 truncate">{{ $agent->name }}</p>
                                            <span class="material-symbols-outlined text-green-500 text-[16px] {{ $isSelected ? '' : 'hidden' }}">check_circle</span>
                                        </div>
                                        <p class="text-xs text-gray-400">{{ $agent->jasas_count }} jasa {{ $jasa->kategori }}</p>
                                        @if($accepted > 0)
                                            <p class="text-xs text-gray-400">{{ $accepted }} pesanan selesai</p>
                                        @endif
                                        <div class="flex gap-2 mt-1">
                                            @if($agent->jasas_count >= 5)
                                                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-lg">Professional</span>
                                            @endif
                                            @if($accepted > 10)
                                                <span class="text-[10px] font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-lg">Populer</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @if($agents->isEmpty())
                        <div class="text-center py-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                            <span class="material-symbols-outlined text-gray-300 text-4xl mb-2 block">group_off</span>
                            <p class="text-gray-400 text-sm font-medium">Belum ada talent tersedia untuk kategori ini.</p>
                        </div>
                    @endif
                    @error('vendor_id')
                        <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</p>
                    @enderror
                </div>

                <hr class="border-gray-100">

                {{-- Section 1: Kontak & Lokasi --}}
                <div>
                    <div class="flex items-center gap-2 mb-5">
                        <span class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[#003fb1] text-[18px]">contact_phone</span>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">Kontak & Lokasi</h3>
                            <p class="text-xs text-gray-400">Data ini akan dikirim ke penyedia jasa</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="phone" class="block text-sm font-bold text-gray-700 mb-1.5">Nomor Telepon <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">+62</span>
                                <input id="phone" name="phone" type="text" inputmode="numeric"
                                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm @error('phone') border-red-300 bg-red-50 @enderror"
                                    placeholder="81234567890" value="{{ old('phone') }}" required>
                            </div>
                            @error('phone')
                                <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="booking_date" class="block text-sm font-bold text-gray-700 mb-1.5">Tanggal Booking <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                                </span>
                                <input id="booking_date" name="booking_date" type="date"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm @error('booking_date') border-red-300 bg-red-50 @enderror"
                                    min="{{ date('Y-m-d') }}" value="{{ old('booking_date') }}" required>
                            </div>
                            @error('booking_date')
                                <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-5">
                        <label for="address" class="block text-sm font-bold text-gray-700 mb-1.5">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea id="address" name="address" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm @error('address') border-red-300 bg-red-50 @enderror"
                            placeholder="Jalan, nomor, kecamatan, kota, kode pos" required>{{ old('address') }}</textarea>
                        @error('address')
                            <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- Section 2: Jadwal Kedatangan --}}
                <div>
                    <div class="flex items-center gap-2 mb-5">
                        <span class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center">
                            <span class="material-symbols-outlined text-green-600 text-[18px]">schedule</span>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">Jadwal Kedatangan</h3>
                            <p class="text-xs text-gray-400">Pilih waktu yang paling sesuai untuk Anda</p>
                        </div>
                    </div>

                    <div>
                        <label for="preferred_time" class="block text-sm font-bold text-gray-700 mb-1.5">Waktu Preferensi</label>
                        <div class="grid grid-cols-3 gap-3">
                            @php $times = ['pagi' => 'Pagi (08:00–12:00)', 'siang' => 'Siang (12:00–16:00)', 'sore' => 'Sore (16:00–20:00)']; @endphp
                            @foreach ($times as $value => $label)
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="preferred_time" value="{{ $value }}"
                                        class="sr-only peer"
                                        {{ old('preferred_time') === $value ? 'checked' : '' }}>
                                    <div class="flex flex-col items-center gap-1.5 p-4 rounded-xl border-2 border-gray-100 bg-white peer-checked:border-[#003fb1] peer-checked:bg-blue-50 hover:border-gray-200 transition-all">
                                        <span class="material-symbols-outlined text-gray-400 peer-checked:text-[#003fb1] text-[22px]">
                                            @if ($value === 'pagi') sunny @elseif ($value === 'siang') light_mode @else dark_mode @endif
                                        </span>
                                        <span class="text-xs font-bold text-gray-600 peer-checked:text-[#003fb1]">{{ $label }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('preferred_time')
                            <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- Section 3: Dokumentasi Foto --}}
                <div>
                    <div class="flex items-center gap-2 mb-5">
                        <span class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center">
                            <span class="material-symbols-outlined text-purple-600 text-[18px]">photo_camera</span>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">Dokumentasi</h3>
                            <p class="text-xs text-gray-400">
                                @php
                                    $photoHint = match($jasa->kategori) {
                                        'Repair' => 'Foto kerusakan atau area yang perlu diperbaiki',
                                        'Cleaning' => 'Foto area atau barang yang akan dibersihkan',
                                        'Creative' => 'Foto referensi atau contoh hasil yang diinginkan',
                                        'Business' => 'Foto dokumen atau area terkait',
                                        default => 'Foto kondisi atau area terkait jasa',
                                    };
                                @endphp
                                {{ $photoHint }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div id="dropzone"
                            class="relative border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-[#003fb1] hover:bg-blue-50/30 transition-all cursor-pointer @error('photos') border-red-300 bg-red-50 @enderror @error('photos.*') border-red-300 bg-red-50 @enderror">
                            <input id="photosInput" name="photos[]" type="file" accept="image/jpeg,image/png" multiple
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                onchange="handlePhotos(this.files)">
                            <div id="dropzoneContent">
                                <span class="material-symbols-outlined text-gray-300 text-5xl mb-3 block">add_photo_alternate</span>
                                <p class="text-sm font-bold text-gray-700">Klik atau seret foto ke sini</p>
                                <p class="text-xs text-gray-400 mt-1">JPG/PNG, maks 5MB per file, minimal <strong>3 foto</strong></p>
                            </div>
                        </div>

                        <div id="photoPreview" class="grid grid-cols-5 gap-3 hidden"></div>

                        <div id="photoCounter" class="text-xs text-gray-500 font-medium hidden">
                            <span id="photoCount">0</span>/5 foto terpilih <span id="photoMinNotice" class="text-red-500 font-bold">(minimal 3)</span>
                        </div>

                        @error('photos')
                            <p class="text-xs text-red-500 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</p>
                        @enderror
                        @error('photos.*')
                            <p class="text-xs text-red-500 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</p>
                        @enderror

                        <div class="bg-purple-50 rounded-xl p-4 flex items-start gap-2">
                            <span class="material-symbols-outlined text-purple-600 text-[18px] mt-0.5">info</span>
                            <p class="text-xs text-gray-600 leading-relaxed">
                                Foto akan membantu penyedia jasa memahami kebutuhan Anda sebelum datang ke lokasi.
                            </p>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- Section 4: Catatan --}}
                <div>
                    <div class="flex items-center gap-2 mb-5">
                        <span class="w-8 h-8 rounded-lg bg-yellow-50 flex items-center justify-center">
                            <span class="material-symbols-outlined text-yellow-600 text-[18px]">edit_note</span>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">Catatan Tambahan</h3>
                            <p class="text-xs text-gray-400">Informasi detail yang perlu diketahui penyedia jasa</p>
                        </div>
                    </div>

                    <div>
                        <textarea id="notes" name="notes" rows="4"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm @error('notes') border-red-300 bg-red-50 @enderror"
                            placeholder="Contoh: ukuran ruangan, bahan yang perlu disiapkan, akses masuk...">{{ old('notes') }}</textarea>
                        <div class="flex justify-between mt-1.5">
                            @error('notes')
                                <p class="text-xs text-red-500 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-400 ml-auto"><span id="notesCounter">0</span>/500</p>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- Section 4: Persetujuan --}}
                <div class="flex items-start gap-3">
                    <input id="terms" type="checkbox" required
                        class="mt-1 w-4 h-4 rounded border-gray-300 text-[#003fb1] focus:ring-[#003fb1]">
                    <label for="terms" class="text-sm text-gray-600">
                        Saya setuju dengan
                        <a href="#" class="text-[#003fb1] font-semibold hover:underline">syarat & ketentuan</a>
                        dan
                        <a href="#" class="text-[#003fb1] font-semibold hover:underline">kebijakan privasi</a>
                        yang berlaku.
                        <span class="text-red-500">*</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" id="submitBtn"
                    class="w-full py-3.5 bg-[#003fb1] text-white rounded-xl text-sm font-bold hover:opacity-90 transition-all shadow-lg shadow-blue-100 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="submitIcon" class="material-symbols-outlined text-[18px]">check</span>
                    <span id="submitText">Konfirmasi Booking</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Summary Sidebar --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:sticky lg:top-24">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">receipt</span>
                Ringkasan Booking
            </h3>

            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                        <img class="w-full h-full object-cover"
                             src="{{ $firstImg ? asset('storage/jasa/' . $firstImg) : 'https://ui-avatars.com/api/?name=' . urlencode($jasa->nama_jasa) . '&background=003fb1&color=fff' }}"
                             alt="{{ $jasa->nama_jasa }}">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ $jasa->nama_jasa }}</p>
                        <p class="text-xs text-gray-400">{{ $jasa->user->name }}</p>
                    </div>
                </div>

                <div class="border-t border-gray-50 pt-4 space-y-2 text-sm">
                    <div class="flex justify-between text-gray-500">
                        <span>Harga Jasa</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($jasa->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500">
                        <span>Biaya Layanan</span>
                        <span class="text-green-600 font-semibold">Gratis</span>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="text-xl font-extrabold text-[#003fb1]">Rp {{ number_format($jasa->harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="bg-blue-50 rounded-xl p-4 mt-2">
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-[#003fb1] text-[18px] mt-0.5">info</span>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Pembayaran dilakukan <strong>setelah</strong> penyedia jasa mengkonfirmasi booking Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
var photosData = [];

function handlePhotos(files) {
    var preview = document.getElementById('photoPreview');
    var counter = document.getElementById('photoCounter');
    var countEl = document.getElementById('photoCount');
    var minNotice = document.getElementById('photoMinNotice');

    var remaining = 5 - photosData.length;
    for (var i = 0; i < Math.min(files.length, remaining); i++) {
        photosData.push(files[i]);
    }

    renderPreviews();
    updateCounter();

    if (photosData.length >= 5) {
        document.getElementById('dropzone').classList.add('opacity-30', 'pointer-events-none');
    } else {
        document.getElementById('dropzone').classList.remove('opacity-30', 'pointer-events-none');
    }

    syncFileInput();
}

function removePhoto(index) {
    photosData.splice(index, 1);
    renderPreviews();
    updateCounter();
    document.getElementById('dropzone').classList.remove('opacity-30', 'pointer-events-none');
    syncFileInput();
}

function renderPreviews() {
    var preview = document.getElementById('photoPreview');
    preview.innerHTML = '';
    if (photosData.length > 0) {
        preview.classList.remove('hidden');
    } else {
        preview.classList.add('hidden');
        return;
    }
    photosData.forEach(function(file, i) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var div = document.createElement('div');
            div.className = 'relative group aspect-square rounded-xl overflow-hidden border border-gray-200 bg-gray-50';
            div.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover">'
                + '<button type="button" onclick="removePhoto(' + i + ')" class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow">'
                + '<span class="material-symbols-outlined text-[14px]">close</span></button>'
                + '<div class="absolute bottom-0 inset-x-0 bg-black/50 text-white text-[10px] text-center py-1 font-medium">Foto ' + (i+1) + '</div>';
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

function updateCounter() {
    var counter = document.getElementById('photoCounter');
    var countEl = document.getElementById('photoCount');
    var minNotice = document.getElementById('photoMinNotice');
    countEl.textContent = photosData.length;
    counter.classList.remove('hidden');
    if (photosData.length >= 3) {
        minNotice.classList.add('hidden');
    } else {
        minNotice.classList.remove('hidden');
    }
}

function syncFileInput() {
    var input = document.getElementById('photosInput');
    var dt = new DataTransfer();
    photosData.forEach(function(file) {
        dt.items.add(file);
    });
    input.files = dt.files;
}

document.addEventListener('DOMContentLoaded', function() {
    var vendorInput = document.getElementById('vendor_id');

    document.querySelectorAll('.agent-card').forEach(function(card) {
        card.addEventListener('click', function() {
            document.querySelectorAll('.agent-card').forEach(function(c) {
                c.classList.remove('border-[#003fb1]', 'bg-blue-50');
                c.classList.add('border-gray-100', 'bg-white');
                c.querySelector('.material-symbols-outlined.text-green-500').classList.add('hidden');
            });
            this.classList.remove('border-gray-100', 'bg-white');
            this.classList.add('border-[#003fb1]', 'bg-blue-50');
            this.querySelector('.material-symbols-outlined.text-green-500').classList.remove('hidden');
            var radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            vendorInput.value = radio.value;
        });
    });

    if (document.querySelector('.agent-card input:checked')) {
        var checked = document.querySelector('.agent-card input:checked');
        checked.closest('.agent-card').click();
    }

    var form = document.getElementById('bookingForm');
    var btn = document.getElementById('submitBtn');
    var icon = document.getElementById('submitIcon');
    var text = document.getElementById('submitText');

    form.addEventListener('submit', function(e) {
        if (photosData.length < 3) {
            e.preventDefault();
            alert('Minimal unggah 3 foto dokumentasi.');
            return;
        }
        btn.disabled = true;
        icon.textContent = 'progress_activity';
        icon.className = 'material-symbols-outlined text-[18px] animate-spin';
        text.textContent = 'Memproses...';
    });

    var notes = document.getElementById('notes');
    var counter = document.getElementById('notesCounter');
    if (notes && counter) {
        counter.textContent = notes.value.length;
        notes.addEventListener('input', function() {
            counter.textContent = this.value.length;
        });
    }
});
</script>
<style>
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
.animate-spin { animation: spin 1s linear infinite; }
</style>
@endpush
@endsection
