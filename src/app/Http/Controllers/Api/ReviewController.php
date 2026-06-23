<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Transaction $transaction)
    {
        if ($transaction->buyer_id !== auth()->id()) {
            return response()->json(['message' => 'Anda tidak memiliki akses untuk memberikan ulasan pada transaksi ini.'], 403);
        }

        if ($transaction->status !== 'selesai') {
            return response()->json(['message' => 'Ulasan hanya dapat diberikan pada transaksi yang sudah selesai.'], 400);
        }

        if ($transaction->review()->exists()) {
            return response()->json(['message' => 'Ulasan sudah diberikan sebelumnya.'], 400);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $review = $transaction->review()->create([
            'rating' => $validated['rating'],
            'comment' => $validated['comment']
        ]);

        return response()->json([
            'message' => 'Ulasan berhasil disimpan.',
            'review' => [
                'buyer_name' => auth()->user()->name,
                'product_name' => $transaction->product->name,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at->toDateTimeString()
            ]
        ]);
    }
}
