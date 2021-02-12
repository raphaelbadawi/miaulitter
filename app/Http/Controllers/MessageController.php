<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MessageController extends Controller
{
    public function show()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();
        $messages = Message::with('author')->where('receiver_id', auth()->user()->id)->get();

        return Inertia::render('Messages/Index', [
            'messages' => $messages,
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required'],
            'receiver' => ['exists:users,id']
        ]);

        Message::create([
            'content' => $request->input('content'),
            'sender_id' => auth()->user()->id,
            'receiver_id' => $request->input('receiver'),
        ]);

        return Redirect::route('messages.show');
    }
}
