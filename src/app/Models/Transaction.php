<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'product_id',
        'buyer_id',
        'quantity',
        'total_price',
        'status',
    ];
}
