<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::id())
            ->with(['product.productImages']) 
            ->latest()
            ->get();

        return view('wishlist.wishlist', compact('wishlists'));
    }

    public function destroy($productId)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        return response()->json(['success' => true, 'message' => 'Produk dihapus dari wishlist']);
    }

    public function clearAll()
    {
        Wishlist::where('user_id', Auth::id())->delete();

        return response()->json(['success' => true, 'message' => 'Semua wishlist berhasil dikosongkan']);
    }
}