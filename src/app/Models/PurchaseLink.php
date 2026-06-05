<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseLink extends Model
{
    protected $fillable = [
        'chat_id',
        'token',
        'deal_price',
        'expired_at',
        'is_used'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'is_used'    => 'boolean',
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * Cek apakah link masih valid (belum dipakai & belum expired)
     */
    public function isValid(): bool
    {
        return !$this->is_used && $this->expired_at->isFuture();
    }
}
