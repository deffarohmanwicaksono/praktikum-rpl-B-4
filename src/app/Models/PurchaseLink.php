<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseLink extends Model
{
    use HasFactory;
    protected $fillable = [
        'chat_id',
        'token',
        'deal_price',
        'expired_at',
        'is_used',
        'note',
        'payment_methods'
    ];

    protected $casts = [
        'expired_at' => 'datetime',
        'is_used'    => 'boolean',
        'payment_methods' => 'array',
    ];

    //Cek apakah link masih valid (belum dipakai & belum expired)
    public function isValid(): bool
    {
        return !$this->is_used && $this->expired_at->isFuture();
    }

    // Relasi dengan model lain
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
