<?php

namespace App\Models;

use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'rating',
        'comment',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
