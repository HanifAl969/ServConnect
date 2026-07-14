@php $isMe = $msg->sender_id === Auth::id(); @endphp
<div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} msg" data-id="{{ $msg->id }}">
    <div class="max-w-[75%] {{ $isMe ? 'bg-[#003fb1] text-white' : 'bg-gray-100 text-gray-900' }} rounded-2xl px-4 py-2.5 shadow-sm">
        @if(!$isMe)
            <p class="text-[10px] font-bold opacity-60 mb-0.5">{{ $msg->sender->name }}</p>
        @endif
        @if($msg->message)
            <p class="text-sm leading-relaxed break-words">{{ $msg->message }}</p>
        @endif
        @if($msg->photo)
            <a href="{{ $msg->photoUrl() }}" target="_blank"
               class="block mt-1.5 rounded-lg overflow-hidden border border-gray-200 hover:ring-2 hover:ring-[#003fb1] transition-all">
                <img src="{{ $msg->photoUrl() }}" class="w-40 h-32 object-cover" alt="Foto">
            </a>
        @endif
        <p class="text-[10px] mt-1 {{ $isMe ? 'text-blue-200' : 'text-gray-400' }} text-right">{{ $msg->created_at->format('H:i') }}</p>
    </div>
</div>
