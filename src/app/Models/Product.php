<?php

namespace App\Models;

use App\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Transaction::class);
    }

    public function verifications()
    {
        return $this->hasOne(ProductVerification::class);
    }
}
