<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Booking $booking)
    {
        $this->authorizeAccess($booking);

        $messages = ChatMessage::where('booking_id', $booking->id)
            ->with('sender')
            ->oldest()
            ->get();

        return view('chat.show', compact('booking', 'messages'));
    }

    public function messages(Booking $booking, Request $request)
    {
        $this->authorizeAccess($booking);

        $after = $request->integer('after', 0);

        $messages = ChatMessage::where('booking_id', $booking->id)
            ->where('id', '>', $after)
            ->with('sender:id,name')
            ->oldest()
            ->get();

        return response()->json($messages->map(fn($m) => [
            'id' => $m->id,
            'sender_id' => $m->sender_id,
            'sender_name' => $m->sender->name,
            'message' => e($m->message),
            'photo' => $m->photoUrl(),
            'is_from_user' => $m->isFromUser(),
            'time' => $m->created_at->format('H:i'),
        ]));
    }

    public function store(Request $request, Booking $booking)
    {
        $this->authorizeAccess($booking);

        $validated = $request->validate([
            'message' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        if (!$request->filled('message') && !$request->hasFile('photo')) {
            return back()->with('error', 'Pesan atau foto harus diisi.');
        }

        $data = [
            'booking_id' => $booking->id,
            'sender_id' => Auth::id(),
            'message' => $request->input('message'),
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('chat', 'public');
        }

        ChatMessage::create($data);

        return redirect()->route('chat.index', $booking);
    }

    private function authorizeAccess(Booking $booking): void
    {
        $user = Auth::user();

        if ($booking->user_id !== $user->id && $booking->vendor_id !== $user->id) {
            abort(403);
        }

        if (!in_array($booking->status, ['accepted', 'completed', 'cancelled'])) {
            abort(403, 'Chat belum tersedia.');
        }
    }
}
