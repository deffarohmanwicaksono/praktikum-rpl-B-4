<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Daftar semua wishlist milik user.
     */
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())
            ->with(['product.productImages', 'product.category'])
            ->latest()
            ->get();

        $data = $wishlists->map(function ($item) {
            $product  = $item->product;
            $imageUrl = $product->productImages->first()?->image_url ?? null;

            if ($imageUrl && !str_starts_with($imageUrl, 'http')) {
                if (str_starts_with($imageUrl, 'products/')) {
                    $imageUrl = asset('storage/' . $imageUrl);
                } else {
                    $imageUrl = asset($imageUrl);
                }
            }

            return [
                'wishlist_id' => $item->id,
                'product'     => [
                    'id'          => $product->id,
                    'name'        => $product->name,
                    'price'       => $product->price,
                    'price_label' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                    'condition'   => $product->condition,
                    'status'      => $product->status,
                    'category'    => $product->category?->name,
                    'image_url'   => $imageUrl ?? asset('images/placeholder.png'),
                ],
            ];
        });

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Tambah produk ke wishlist — jika sudah ada, hapus (toggle).
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId    = Auth::id();
        $productId = $request->product_id;

        $existing = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json([
                'success'    => true,
                'wishlisted' => false,
                'message'    => 'Produk dihapus dari wishlist.',
            ]);
        }

        Wishlist::create([
            'user_id'    => $userId,
            'product_id' => $productId,
        ]);

        return response()->json([
            'success'    => true,
            'wishlisted' => true,
            'message'    => 'Produk ditambahkan ke wishlist.',
        ]);
    }

    /**
     * Hapus satu produk dari wishlist.
     */
    public function destroy($productId)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari wishlist.',
        ]);
    }

    /**
     * Kosongkan semua wishlist milik user.
     */
    public function clearAll()
    {
        Wishlist::where('user_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'Semua wishlist berhasil dikosongkan.',
        ]);
    }
}