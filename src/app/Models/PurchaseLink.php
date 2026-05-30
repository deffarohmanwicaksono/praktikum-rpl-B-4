<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseLink extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'chat_id',
        'token',
        'deal_price',
        'expired_at',
        'is_used'
    ];
}
