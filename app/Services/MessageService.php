<?php

namespace App\Services;

use App\Models\Message;

class MessageService
{
    public function getUnread($user): int
    {
        return Message::where('receiver', $user)->where('read', false)->count();
    }
}
