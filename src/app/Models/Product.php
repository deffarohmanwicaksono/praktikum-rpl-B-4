<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'price',
        'stock',
        'condition',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function purchaseLinks()
    {
        return $this->hasMany(PurchaseLink::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
