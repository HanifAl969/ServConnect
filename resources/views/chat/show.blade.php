@extends(Auth::user()->role === 'admin' ? 'layouts.admin' : (Auth::user()->role === 'vendor' ? 'layouts.vendor' : 'layouts.user'))

@section('title', 'Chat — ServeConnect')

@section('header', 'Chat')

@section('content')
@php
    $isVendor = Auth::user()->role === 'vendor';
    $otherParty = $isVendor ? $booking->user : $booking->vendor;
    $backRoute = $isVendor ? route('vendor.bookings') : route('bookings.index');
@endphp

<a href="{{ $backRoute }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-[#003fb1] mb-4 transition-colors">
    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
    Kembali ke {{ $isVendor ? 'Booking Masuk' : 'Booking Saya' }}
</a>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col h-[calc(100vh-16rem)]">
    {{-- Header: Alamat + Status --}}
    <div class="p-4 border-b border-gray-100 bg-gray-50/50 shrink-0">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-full bg-[#003fb1] flex items-center justify-center text-white font-bold text-sm shrink-0">
                    {{ substr($otherParty->name, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-bold text-gray-900 truncate">{{ $otherParty->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ $booking->jasa->nama_jasa }}</p>
                </div>
            </div>
            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase shrink-0
                @if ($booking->status === 'accepted') bg-green-50 text-green-600
                @elseif ($booking->status === 'completed') bg-blue-50 text-blue-600
                @else bg-red-50 text-red-600 @endif">
                {{ $booking->status }}
            </span>
        </div>
        @if($booking->address)
        <div class="flex items-start gap-1.5 mt-2 text-xs text-gray-400">
            <span class="material-symbols-outlined text-[14px] mt-0.5">location_on</span>
            <span class="leading-relaxed">{{ $booking->address }}</span>
        </div>
        @endif
    </div>

    {{-- Messages --}}
    <div id="chatMessages" class="flex-1 overflow-y-auto p-4 space-y-3">
        @forelse($messages as $msg)
            @include('chat._message', ['msg' => $msg])
        @empty
            <div class="text-center py-12" id="emptyChat">
                <span class="material-symbols-outlined text-gray-200 text-5xl mb-3 block">chat</span>
                <p class="text-gray-400 text-sm font-medium">Belum ada pesan.</p>
                <p class="text-xs text-gray-300 mt-1">Mulai percakapan dengan {{ $otherParty->name }}.</p>
            </div>
        @endforelse
    </div>

    {{-- Input --}}
    @if(in_array($booking->status, ['accepted', 'completed']))
    <div class="border-t border-gray-100 p-4 bg-white shrink-0">
        <form id="chatForm" method="POST" action="{{ route('chat.store', $booking) }}" enctype="multipart/form-data" class="flex items-end gap-3">
            @csrf
            <label class="shrink-0 w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 hover:border-[#003fb1] hover:bg-blue-50 cursor-pointer transition-all" title="Kirim foto">
                <input type="file" name="photo" accept="image/jpeg,image/png" class="hidden" id="photoInput" onchange="previewPhoto(this)">
                <span class="material-symbols-outlined text-gray-400 text-[20px]">photo_camera</span>
            </label>
            <div class="flex-1 relative">
                <textarea id="messageInput" name="message" rows="1" placeholder="Tulis pesan..." maxlength="1000" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm resize-none" oninput="autoResize(this)"></textarea>
                <span id="photoPreview" class="hidden mt-2"></span>
            </div>
            <button type="submit" class="shrink-0 w-10 h-10 flex items-center justify-center rounded-xl bg-[#003fb1] text-white hover:opacity-90 transition-all">
                <span class="material-symbols-outlined text-[20px]">send</span>
            </button>
        </form>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
var bookingId = {{ $booking->id }};
var userId = {{ Auth::id() }};
var lastId = 0;
var polling = true;

function appendMessage(msg) {
    var container = document.getElementById('chatMessages');
    var existing = container.querySelector('.msg[data-id="' + msg.id + '"]');
    if (existing) return;

    var empty = document.getElementById('emptyChat');
    if (empty) empty.remove();

    var isMe = msg.sender_id === userId;
    var div = document.createElement('div');
    div.className = 'flex ' + (isMe ? 'justify-end' : 'justify-start');
    div.dataset.id = msg.id;
    div.innerHTML = '<div class="max-w-[75%] ' + (isMe ? 'bg-[#003fb1] text-white' : 'bg-gray-100 text-gray-900') + ' rounded-2xl px-4 py-2.5 shadow-sm">'
        + (!isMe ? '<p class="text-[10px] font-bold opacity-60 mb-0.5">' + escapeHtml(msg.sender_name) + '</p>' : '')
        + (msg.message ? '<p class="text-sm leading-relaxed break-words">' + escapeHtml(msg.message) + '</p>' : '')
        + (msg.photo ? '<a href="' + msg.photo + '" target="_blank" class="block mt-1.5 rounded-lg overflow-hidden border border-gray-200 hover:ring-2 hover:ring-[#003fb1] transition-all"><img src="' + msg.photo + '" class="w-40 h-32 object-cover" alt="Foto"></a>' : '')
        + '<p class="text-[10px] mt-1 ' + (isMe ? 'text-blue-200' : 'text-gray-400') + ' text-right">' + msg.time + '</p>'
        + '</div>';
    container.appendChild(div);
    scrollToBottom();
    lastId = msg.id;
}

function scrollToBottom() {
    var container = document.getElementById('chatMessages');
    container.scrollTop = container.scrollHeight;
}

function escapeHtml(text) {
    var d = document.createElement('div');
    d.textContent = text;
    return d.innerHTML;
}

function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = el.scrollHeight + 'px';
}

function previewPhoto(input) {
    var preview = document.getElementById('photoPreview');
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = '<div class="inline-flex items-center gap-2 bg-gray-50 rounded-lg p-2 border border-gray-200"><img src="' + e.target.result + '" class="w-12 h-12 object-cover rounded"><span class="text-xs text-gray-500">Foto terpilih</span></div>';
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var lastMsg = document.querySelector('.msg:last-child');
    if (lastMsg) lastId = parseInt(lastMsg.dataset.id);
    scrollToBottom();

    var form = document.getElementById('chatForm');
    if (form) {
        form.addEventListener('submit', function() {
            var btn = this.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<span class="material-symbols-outlined text-[20px]">more_horiz</span>';
        });
    }

    setInterval(function() {
        if (!polling) return;
        fetch('/booking/' + bookingId + '/chat/messages?after=' + lastId)
            .then(function(r) { return r.json(); })
            .then(function(msgs) {
                msgs.forEach(function(m) { appendMessage(m); });
            })
            .catch(function() {});
    }, 3000);
});
</script>
<style>
#chatMessages { scroll-behavior: smooth; }
#chatMessages::-webkit-scrollbar { width: 4px; }
#chatMessages::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
</style>
@endpush
