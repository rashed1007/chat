<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ChatInterface;
use Illuminate\Http\Request;

class ChatController extends Controller
{


    public $chatInterface;

    public function __construct(ChatInterface $chatInterface)
    {
        $this->chatInterface = $chatInterface;
    }
    public function getChats()
    {
        return $this->chatInterface->getChats();
    }

    public function getUserChat($user_id)
    {
        return $this->chatInterface->getUserChat($user_id);
    }


    public function sendMessage(Request $request, $user_id)
    {
        return $this->chatInterface->sendMessage($request, $user_id);
    }
}
