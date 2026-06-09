<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;

Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    $chat = Chat::find($chatId);

    return $chat && ((int) $user->id === (int) $chat->buyer_id || (int) $user->id === (int) $chat->seller_id);
});
