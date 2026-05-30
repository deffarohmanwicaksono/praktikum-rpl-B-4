<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(string $id)
    {
        $product = Product::with(['productImages', 'user', 'category'])
            ->findOrFail($id);

        return view('products.detail-product', [
            'product' => $product
        ]);
    }

    public function search(Request $request)
{
    $keyword = $request->get('q');

    $products = Product::with(['productImages', 'category'])
        ->where('status', 'dijual')
        ->where(function($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
        })
        ->get();

    return view('products.search', [
        'keyword' => $keyword,
        'products' => $products
    ]);
}
}
