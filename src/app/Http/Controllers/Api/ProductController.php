<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Helper: resolve URL gambar produk ke URL publik penuh.
     */
    private function resolveImageUrl(?string $imageUrl): string
    {
        if (!$imageUrl) {
            return asset('images/placeholder.png');
        }

        // Unsplash / external URL
        if (str_starts_with($imageUrl, 'http')) {
            return $imageUrl;
        }

        // Upload user
        if (str_starts_with($imageUrl, 'products/')) {
            return asset('storage/' . $imageUrl);
        }

        // Asset bawaan repo
        return asset($imageUrl);
    }

    /**
     * Helper: format data produk untuk response JSON.
     */
    private function formatProduct(Product $product, array $wishlistedIds = []): array
    {
        return [
            'id'          => $product->id,
            'name'        => $product->name,
            'description' => $product->description,
            'price'       => $product->price,
            'price_label' => 'Rp ' . number_format($product->price, 0, ',', '.'),
            'condition'   => $product->condition,
            'status'      => $product->status,
            'category'    => $product->category?->name,
            'seller'      => [
                'id'   => $product->user?->id,
                'name' => $product->user?->name,
            ],
            'images'      => $product->productImages->map(fn($img) => [
                'id'  => $img->id,
                'url' => $this->resolveImageUrl($img->image_url),
            ]),
            'is_wishlisted' => in_array($product->id, $wishlistedIds),
            'created_at'  => $product->created_at?->toDateTimeString(),
        ];
    }

    /**
     * Beranda — daftar produk aktif dengan filter kategori & sort.
     */
    public function index(Request $request)
    {
        $query = Product::with(['productImages', 'category', 'user'])
            ->availableForSale();

        $catMap = [
            'elektronik' => 1, 'buku'       => 2, 'perabot'    => 3,
            'pakaian'    => 4, 'olahraga'   => 5, 'hobi'       => 6,
            'kecantikan' => 7, 'lainnya'    => 8,
        ];

        if ($request->filled('category') && $request->category !== 'semua') {
            if (isset($catMap[$request->category])) {
                $query->where('category_id', $catMap[$request->category]);
            }
        }

        switch ($request->input('sort', 'terbaru')) {
            case 'terlama':  $query->orderBy('created_at', 'asc');  break;
            case 'termurah': $query->orderBy('price', 'asc');        break;
            case 'termahal': $query->orderBy('price', 'desc');       break;
            default:         $query->orderBy('created_at', 'desc');  break;
        }

        $products      = $query->get();
        $wishlistedIds = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        return response()->json([
            'data' => $products->map(fn($p) => $this->formatProduct($p, $wishlistedIds)),
        ]);
    }

    /**
     * Detail satu produk.
     */
    public function show(string $id)
    {
        $product = Product::with(['productImages', 'user', 'category'])->findOrFail($id);

        $reviewsQuery      = Review::whereHas('transaction.product', fn($q) => $q->where('user_id', $product->user_id));
        $sellerReviewCount = $reviewsQuery->count();
        $sellerRating      = $sellerReviewCount > 0 ? round($reviewsQuery->avg('rating'), 1) : null;

        $wishlistedIds = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        return response()->json([
            'data' => array_merge($this->formatProduct($product, $wishlistedIds), [
                'seller_rating'        => $sellerRating,
                'seller_reviews_count' => $sellerReviewCount,
            ]),
        ]);
    }

    /**
     * Cari produk berdasarkan keyword / kategori.
     */
    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $query   = Product::with(['productImages', 'category', 'user'])->availableForSale();

        $catMap = [
            'elektronik'       => 1,
            'buku'             => 2,
            'perabot'          => 3,
            'perlengkapan kos' => 3, // alias for mobile
            'pakaian'          => 4,
            'fashion'          => 4, // alias for mobile
            'olahraga'         => 5,
            'hobi'             => 6,
            'kecantikan'       => 7,
            'lainnya'          => 8,
        ];

        if ($request->filled('category') && $request->category !== 'semua') {
            if (isset($catMap[$request->category])) {
                $query->where('category_id', $catMap[$request->category]);
            }
            $keyword = null;
        } elseif ($request->filled('q')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        switch ($request->input('sort', 'terbaru')) {
            case 'terlama':  $query->orderBy('created_at', 'asc');  break;
            case 'termurah': $query->orderBy('price', 'asc');        break;
            case 'termahal': $query->orderBy('price', 'desc');       break;
            default:         $query->orderBy('created_at', 'desc');  break;
        }

        $products      = $query->get();
        $wishlistedIds = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        return response()->json([
            'keyword' => $keyword,
            'data'    => $products->map(fn($p) => $this->formatProduct($p, $wishlistedIds)),
        ]);
    }

    /**
     * Profil seller — info seller + review.
     */
    public function sellerProfile(string $id)
    {
        $sellerUser = User::findOrFail($id);

        $soldCount = Transaction::whereHas('product', fn($q) => $q->where('user_id', $sellerUser->id))
            ->where('status', 'selesai')->count();

        $sellerProductIds = Product::where('user_id', $sellerUser->id)->pluck('id');
        $reviewsQuery     = Review::whereHas('transaction', fn($q) => $q->whereIn('product_id', $sellerProductIds));
        $reviewsCount     = $reviewsQuery->count();
        $rating           = $reviewsCount > 0 ? round($reviewsQuery->avg('rating'), 1) : 0;

        $reviews = $reviewsQuery->with(['transaction.buyer', 'transaction.product'])
            ->latest()->take(5)->get()
            ->map(fn($r) => [
                'buyer_name'   => $r->transaction?->buyer?->name,
                'product_name' => $r->transaction?->product?->name,
                'rating'       => $r->rating,
                'comment'      => $r->comment,
                'created_at'   => $r->created_at?->toDateTimeString(),
            ]);

        return response()->json([
            'seller' => [
                'id'            => $sellerUser->id,
                'name'          => $sellerUser->name,
                'joined'        => $sellerUser->created_at?->format('d M Y'),
                'sold_count'    => $soldCount,
                'rating'        => $rating,
                'reviews_count' => $reviewsCount,
            ],
            'reviews' => $reviews,
        ]);
    }
}