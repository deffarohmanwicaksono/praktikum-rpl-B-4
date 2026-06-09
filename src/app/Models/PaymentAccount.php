<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAccount extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentAccountFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method',
        'account_number',
        'account_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
