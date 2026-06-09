<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'chat_id',
        'sender_id',
        'message'
    ];
}
