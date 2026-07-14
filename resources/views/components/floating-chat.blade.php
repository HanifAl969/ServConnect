@php
    $category = $category ?? null;
@endphp

<div id="fc-root">
    {{-- Greeting badge --}}
    <div id="fc-greeting"
         class="fixed bottom-24 right-6 z-50 bg-white border border-gray-200 rounded-2xl shadow-xl px-5 py-3 max-w-60 hidden">
        <p class="text-sm text-gray-700 font-medium">Halo! 👋 Ada yang bisa saya bantu tentang layanan di ServeConnect?</p>
        <button onclick="document.getElementById('fc-greeting').classList.add('hidden')"
                class="absolute -top-2 -right-2 w-5 h-5 bg-gray-300 rounded-full text-white text-xs flex items-center justify-center hover:bg-gray-400">&times;</button>
    </div>

    {{-- Chat popup --}}
    <div id="fc-popup"
         class="fixed bottom-24 right-6 z-50 w-[360px] h-[500px] bg-white rounded-2xl border border-gray-200 shadow-2xl flex flex-col overflow-hidden hidden">
        {{-- Header --}}
        <div class="p-4 bg-[#003fb1] text-white flex items-center gap-3 shrink-0">
            <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-white text-[18px]">smart_toy</span>
            </div>
            <div class="flex-1">
                <p class="font-bold text-sm">Asisten ServeConnect</p>
                <p class="text-[10px] text-blue-200">Online</p>
            </div>
            <button onclick="fcToggle()" class="w-8 h-8 hover:bg-white/10 rounded-lg flex items-center justify-center transition">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        {{-- Messages --}}
        <div id="fc-messages" class="flex-1 overflow-y-auto p-4 space-y-3 bg-[#fafbfc]">
            <div class="flex gap-2">
                <div class="w-7 h-7 rounded-lg bg-[#003fb1] flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-white text-[14px]">smart_toy</span>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl rounded-tl-none px-4 py-2.5 max-w-[80%] shadow-sm">
                    <p class="text-sm text-gray-700">
                        @if($category)
                            Halo! Saya lihat Anda mencari jasa <strong>{{ $category }}</strong>. Ada yang bisa saya bantu?
                        @else
                            Halo! Saya Asisten ServeConnect. Ada yang bisa saya bantu tentang layanan jasa atau platform ini?
                        @endif
                    </p>
                </div>
            </div>
        </div>

        {{-- Input --}}
        <div class="p-3 border-t border-gray-100 bg-white shrink-0">
            <form id="fc-form" class="flex gap-2">
                <input type="text" id="fc-input"
                       class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm"
                       placeholder="Ketik pesan..." required autofocus>
                <button type="submit"
                        class="px-4 py-2.5 bg-[#003fb1] text-white rounded-xl text-sm font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-100 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[18px]">send</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Floating button --}}
    <button id="fc-toggle"
            onclick="fcToggle()"
            class="fixed bottom-6 right-6 z-50 w-14 h-14 bg-[#003fb1] text-white rounded-full shadow-xl hover:bg-blue-700 active:scale-95 transition-all flex items-center justify-center">
        <span id="fc-icon-bot" class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">smart_toy</span>
        <span id="fc-icon-close" class="material-symbols-outlined hidden" style="font-variation-settings: 'FILL' 1;">close</span>
    </button>
</div>

<script>
var fcOpen = false;
var fcGreetingTimer = null;

function fcToggle() {
    fcOpen = !fcOpen;
    document.getElementById('fc-popup').classList.toggle('hidden', !fcOpen);
    document.getElementById('fc-icon-bot').classList.toggle('hidden', fcOpen);
    document.getElementById('fc-icon-close').classList.toggle('hidden', !fcOpen);
    document.getElementById('fc-greeting').classList.add('hidden');
    if (fcGreetingTimer) clearTimeout(fcGreetingTimer);
    if (fcOpen) {
        setTimeout(function () {
            var m = document.getElementById('fc-messages');
            if (m) m.scrollTop = m.scrollHeight;
        }, 100);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    fcGreetingTimer = setTimeout(function () {
        if (!fcOpen) document.getElementById('fc-greeting').classList.remove('hidden');
    }, 5000);

    var form = document.getElementById('fc-form');
    var input = document.getElementById('fc-input');
    var messages = document.getElementById('fc-messages');
    var isAuthenticated = document.querySelector('meta[name="user-authenticated"]')?.content === '1';

    function addMessage(text, isUser) {
        var div = document.createElement('div');
        div.className = 'flex gap-2 ' + (isUser ? 'justify-end' : '');
        div.innerHTML =
            (!isUser
                ? '<div class="w-7 h-7 rounded-lg bg-[#003fb1] flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-white text-[14px]">smart_toy</span></div>'
                : '') +
            '<div class="' + (isUser ? 'bg-[#003fb1] text-white' : 'bg-white border border-gray-100') + ' rounded-2xl ' + (isUser ? 'rounded-tr-none' : 'rounded-tl-none') + ' px-4 py-2.5 max-w-[80%] shadow-sm"><p class="text-sm">' + text + '</p></div>' +
            (isUser
                ? '<div class="w-7 h-7 rounded-lg bg-gray-100 flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-gray-500 text-[14px]">person</span></div>'
                : '');
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    function addTyping() {
        var div = document.createElement('div');
        div.id = 'fc-typing';
        div.className = 'flex gap-2';
        div.innerHTML =
            '<div class="w-7 h-7 rounded-lg bg-[#003fb1] flex items-center justify-center shrink-0"><span class="material-symbols-outlined text-white text-[14px]">smart_toy</span></div>' +
            '<div class="bg-white border border-gray-100 rounded-2xl rounded-tl-none px-4 py-3 shadow-sm">' +
            '<div class="flex gap-1">' +
            '<span class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay:0ms"></span>' +
            '<span class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay:150ms"></span>' +
            '<span class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay:300ms"></span>' +
            '</div></div>';
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    function removeTyping() {
        var el = document.getElementById('fc-typing');
        if (el) el.remove();
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        var text = input.value.trim();
        if (!text) return;

        addMessage(text, true);
        input.value = '';
        addTyping();

        var endpoint = '/api/chat/public';
        var headers = { 'Content-Type': 'application/json', 'Accept': 'application/json' };
        var csrf = document.querySelector('meta[name="csrf-token"]');
        if (csrf) headers['X-CSRF-TOKEN'] = csrf.content;

        try {
            var res = await fetch(endpoint, { method: 'POST', headers: headers, body: JSON.stringify({ message: text }) });
            var data = await res.json();
            removeTyping();
            if (data.success) {
                addMessage(data.reply, false);
            } else {
                addMessage('Maaf, ' + (data.error || 'terjadi kesalahan. Silakan coba lagi.'), false);
            }
        } catch (err) {
            removeTyping();
            addMessage('Maaf, terjadi kesalahan koneksi. Silakan coba lagi.', false);
        }
    });
});
</script>

<style>
#fc-messages .animate-bounce { animation: fc-bounce 1s infinite; }
@keyframes fc-bounce {
    0%, 100% { transform: translateY(0); opacity: 0.4; }
    50% { transform: translateY(-4px); opacity: 1; }
}
</style>
