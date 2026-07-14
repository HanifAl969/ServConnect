@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : (Auth::user()->role === 'vendor' ? 'layouts.vendor' : 'layouts.user'))

@section('title', 'Pembayaran — ServeConnect')

@section('header', 'Pembayaran')

@section('content')
<a href="{{ route('bookings.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#003fb1] mb-6 transition-colors">
    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
    Kembali ke Booking
</a>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Form Column --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-50 bg-gray-50/50">
                <h2 class="text-xl font-bold text-gray-900">{{ $booking->jasa->nama_jasa }}</h2>
                <p class="text-xs text-gray-500 font-medium mt-1">Penyedia: {{ $booking->vendor->name }}</p>
            </div>

            <form action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                <div>
                    <div class="flex items-center gap-2 mb-5">
                        <span class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center">
                            <span class="material-symbols-outlined text-green-600 text-[18px]">account_balance</span>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">Transfer Bank</h3>
                            <p class="text-xs text-gray-400">Lakukan transfer ke rekening berikut</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Bank</span>
                            <span class="text-sm font-bold text-gray-900">{{ config('payment.bank_name') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Nomor Rekening</span>
                            <span class="text-sm font-bold text-gray-900 font-mono">{{ config('payment.bank_account') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Atas Nama</span>
                            <span class="text-sm font-bold text-gray-900">{{ config('payment.bank_holder') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                            <span class="text-sm font-bold text-gray-700">Total Transfer</span>
                            <span class="text-xl font-extrabold text-[#003fb1]">Rp {{ number_format($booking->jasa->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                <div>
                    <div class="flex items-center gap-2 mb-5">
                        <span class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[#003fb1] text-[18px]">upload_file</span>
                        </span>
                        <div>
                            <h3 class="font-bold text-gray-900">Upload Bukti Transfer</h3>
                            <p class="text-xs text-gray-400">Kirim screenshot/scan bukti pembayaran</p>
                        </div>
                    </div>

                    <div>
                        <div id="proofDropzone"
                            class="relative border-2 border-dashed border-gray-200 rounded-xl p-8 text-center hover:border-[#003fb1] hover:bg-blue-50/30 transition-all cursor-pointer @error('payment_proof') border-red-300 bg-red-50 @enderror">
                            <input id="proofInput" name="payment_proof" type="file" accept="image/jpeg,image/png"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required
                                onchange="handleProof(this.files[0])">
                            <div id="proofContent">
                                <span class="material-symbols-outlined text-gray-300 text-5xl mb-3 block">add_photo_alternate</span>
                                <p class="text-sm font-bold text-gray-700">Klik atau seret foto bukti transfer</p>
                                <p class="text-xs text-gray-400 mt-1">JPG/PNG, maks 5MB</p>
                            </div>
                            <div id="proofPreview" class="hidden mt-4">
                                <img id="proofImg" class="max-h-48 mx-auto rounded-xl border border-gray-200 shadow-sm" alt="Preview bukti transfer">
                            </div>
                        </div>
                        @error('payment_proof')
                            <p class="text-xs text-red-500 mt-1.5 flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">error</span>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <hr class="border-gray-100">

                <div class="bg-blue-50 rounded-xl p-5 flex items-start gap-3">
                    <span class="material-symbols-outlined text-[#003fb1] mt-0.5 shrink-0">info</span>
                    <div>
                        <p class="text-sm font-bold text-[#003fb1]">Penting</p>
                        <p class="text-xs text-gray-600 mt-1">Pembayaran akan dikonfirmasi oleh penyedia jasa setelah bukti transfer diverifikasi. Proses maksimal 1x24 jam.</p>
                    </div>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full py-3.5 bg-[#003fb1] text-white rounded-xl text-sm font-bold hover:opacity-90 transition-all shadow-lg shadow-blue-100 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="submitIcon" class="material-symbols-outlined text-[18px]">check</span>
                    <span id="submitText">Kirim Bukti Pembayaran</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Summary --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:sticky lg:top-24">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">receipt</span>
                Ringkasan
            </h3>
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden flex-shrink-0">
                        @php $firstImg = is_array($booking->jasa->gambar) ? ($booking->jasa->gambar[0] ?? null) : $booking->jasa->gambar; @endphp
                        <img class="w-full h-full object-cover"
                             src="{{ $firstImg ? asset('storage/jasa/' . $firstImg) : 'https://ui-avatars.com/api/?name=' . urlencode($booking->jasa->nama_jasa) . '&background=003fb1&color=fff' }}"
                             alt="{{ $booking->jasa->nama_jasa }}">
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-gray-900 truncate">{{ $booking->jasa->nama_jasa }}</p>
                        <p class="text-xs text-gray-400">{{ $booking->vendor->name }}</p>
                    </div>
                </div>
                <div class="border-t border-gray-50 pt-4 space-y-2 text-sm">
                    <div class="flex justify-between text-gray-500">
                        <span>Tanggal Booking</span>
                        <span class="font-bold text-gray-900">{{ $booking->booking_date->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500">
                        <span>Harga Jasa</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($booking->jasa->harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500">
                        <span>Biaya Layanan</span>
                        <span class="text-green-600 font-semibold">Gratis</span>
                    </div>
                </div>
                <div class="border-t border-gray-100 pt-4">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-900">Total</span>
                        <span class="text-xl font-extrabold text-[#003fb1]">Rp {{ number_format($booking->jasa->harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function handleProof(file) {
    var preview = document.getElementById('proofPreview');
    var img = document.getElementById('proofImg');
    var content = document.getElementById('proofContent');
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            img.src = e.target.result;
            preview.classList.remove('hidden');
            content.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('bookingForm');
    var btn = document.getElementById('submitBtn');
    var icon = document.getElementById('submitIcon');
    var text = document.getElementById('submitText');
    if (form && btn) {
        form.addEventListener('submit', function() {
            btn.disabled = true;
            icon.textContent = 'progress_activity';
            icon.className = 'material-symbols-outlined text-[18px] animate-spin';
            text.textContent = 'Mengupload...';
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
