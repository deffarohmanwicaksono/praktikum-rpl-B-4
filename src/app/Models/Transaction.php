<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'purchase_link_id',
        'buyer_id',
        'product_id',
        'quantity',
        'total_price',
        'status',
        'payment_method',
        'payment_proof',
        'paid_at',
        'completed_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relasi dengan model lain
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function purchaseLink(): BelongsTo
    {
        return $this->belongsTo(PurchaseLink::class);
    }
}
