<?php


namespace App\Http\Interfaces;

interface ChatInterface
{
    public function getChats();

    public function getUserChat($user_id);

    public function sendMessage($request, $user_id);
}
