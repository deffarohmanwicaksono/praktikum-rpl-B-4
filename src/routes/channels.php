<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;

// Private channel untuk chat — mendukung auth via Sanctum token (mobile)
// maupun session (web). Guard 'sanctum' mencakup keduanya.
Broadcast::channel('chat.{chatId}', function ($user, $chatId) {
    $chat = Chat::find($chatId);

    return $chat && ((int) $user->id === (int) $chat->buyer_id || (int) $user->id === (int) $chat->seller_id);
}, ['guards' => ['sanctum', 'web']]);
