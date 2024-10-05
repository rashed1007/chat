<?php

namespace App\Http\Services;

use App\Events\MessageSeen;
use App\Events\MessageSent;
use App\Http\Interfaces\ChatInterface;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatService implements ChatInterface
{
    public function getChats()
    {
        $auth_user_id = Auth::id();

        $users = User::where('id', '!=', $auth_user_id)->get(); // Retrieve all users except the authenticated one
        return view('chats', ['users' => $users]);
    }


    public function getUserChat($user_id)
    {

        $auth_id = Auth::id();   //sender_id
        $username = User::where('id',  $user_id)?->first()?->name;

        // Update last seen for the authenticated user
        $user = User::where('id', $auth_id)->first();
        $user->last_seen = now();
        $last_seen = $user->last_seen;


        // Mark unread messages as seen for the authenticated user
        Message::where('recipient_id', $auth_id)
            ->where('sender_id', $user_id)
            ->where('is_seen', false)
            ->update(['is_seen' => true]);


        $messages = Message::whereIn('sender_id', [$auth_id, $user_id])->whereIn('recipient_id', [$auth_id, $user_id])->get();
        return view('user_chat', ['messages' => $messages, 'username' => $username, 'user_id' => $user_id, 'last_seen' => $last_seen]);
    }


    public function sendMessage($request, $user_id)
    {

        $auth_id = Auth::id();   //sender_id
        $message = $request->message;

        $message = Message::create([
            'sender_id' => $auth_id,
            'recipient_id' => $user_id,
            'content' => $message,
        ]);


        // Update last seen for the authenticated user
        $user = User::where('id', $auth_id)->first();
        $user->update(['last_seen' =>  now()]);


        // Broadcast the message
        broadcast(new MessageSent($message))->toOthers();


        return redirect()->route('profile.getUserChat', ['user_id' => $user_id]);
    }
}
