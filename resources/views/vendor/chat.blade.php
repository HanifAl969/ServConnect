@extends('layouts.vendor')

@section('title', 'Chatbot — ServeConnect')

@section('header', 'Chatbot AI')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex items-center gap-4">
            <div class="w-12 h-12 bg-[#003fb1] rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-white">smart_toy</span>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">Asisten AI ServConnect</h2>
                <p class="text-xs text-gray-500 font-medium">Tanyakan apa pun tentang platform ini</p>
            </div>
        </div>

        <div id="chat-messages" class="h-96 overflow-y-auto p-6 space-y-4 bg-[#fafbfc]">
            <div class="flex gap-3">
                <div class="w-8 h-8 rounded-lg bg-[#003fb1] flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-white text-[16px]">smart_toy</span>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl rounded-tl-none px-5 py-3 max-w-[80%] shadow-sm">
                    <p class="text-sm text-gray-700">Halo! Saya asisten AI ServConnect. Ada yang bisa saya bantu tentang layanan jasa, booking, atau platform ini?</p>
                </div>
            </div>
        </div>

        <div class="p-4 border-t border-gray-100 bg-white">
            <form id="chat-form" class="flex gap-3">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input id="chat-input" type="text"
                    class="flex-1 px-5 py-3 rounded-xl border border-gray-200 focus:border-[#003fb1] focus:ring-1 focus:ring-[#003fb1] outline-none transition-all text-sm"
                    placeholder="Ketik pesan Anda..." required autofocus>
                <button type="submit"
                    class="px-6 py-3 bg-[#003fb1] text-white rounded-xl text-sm font-bold hover:opacity-90 transition-all shadow-lg shadow-blue-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">send</span>
                    <span class="hidden sm:inline">Kirim</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('chat-form');
    const input = document.getElementById('chat-input');
    const messages = document.getElementById('chat-messages');

    function addMessage(text, isUser) {
        const div = document.createElement('div');
        div.className = 'flex gap-3 ' + (isUser ? 'justify-end' : '');
        div.innerHTML = `
            ${!isUser ? `<div class="w-8 h-8 rounded-lg bg-[#003fb1] flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-white text-[16px]">smart_toy</span>
            </div>` : ''}
            <div class="${isUser ? 'bg-[#003fb1] text-white' : 'bg-white border border-gray-100'} rounded-2xl ${isUser ? 'rounded-tr-none' : 'rounded-tl-none'} px-5 py-3 max-w-[80%] shadow-sm">
                <p class="text-sm">${text}</p>
            </div>
            ${isUser ? `<div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-gray-500 text-[16px]">person</span>
            </div>` : ''}
        `;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    function addTyping() {
        const div = document.createElement('div');
        div.id = 'typing-indicator';
        div.className = 'flex gap-3';
        div.innerHTML = `
            <div class="w-8 h-8 rounded-lg bg-[#003fb1] flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-white text-[16px]">smart_toy</span>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl rounded-tl-none px-5 py-3 shadow-sm">
                <div class="flex gap-1">
                    <span class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay:0ms"></span>
                    <span class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay:150ms"></span>
                    <span class="w-2 h-2 bg-gray-300 rounded-full animate-bounce" style="animation-delay:300ms"></span>
                </div>
            </div>
        `;
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
    }

    function removeTyping() {
        const el = document.getElementById('typing-indicator');
        if (el) el.remove();
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const text = input.value.trim();
        if (!text) return;

        addMessage(text, true);
        input.value = '';
        addTyping();

        try {
            const res = await fetch('/api/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                },
                body: JSON.stringify({ message: text }),
            });

            const data = await res.json();
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
.animate-bounce { animation: bounce 1s infinite; }
@keyframes bounce {
    0%, 100% { transform: translateY(0); opacity: 0.4; }
    50% { transform: translateY(-4px); opacity: 1; }
}
</style>
@endsection