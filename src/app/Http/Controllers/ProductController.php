<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    $keyword = $request->input('q');

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


public function create()
{
    $categories = \App\Models\Category::all();

    return view('seller.upload-product', [
        'categories' => $categories
    ]);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name'        => 'required|string|max:200',
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
        'category_id' => 'nullable|exists:categories,id',
        'images'      => 'required|array|min:1',
        'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $product = Product::create([
        'user_id'     => auth()->id(),
        'category_id' => $validated['category_id'] ?? null,
        'name'        => $validated['name'],
        'description' => $validated['description'] ?? null,
        'price'       => $validated['price'],
        'status'      => 'menunggu_verifikasi',
    ]);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('products', 'public');
            $product->productImages()->create([
                'image_path' => $path
            ]);
        }
    }

    return redirect()->route('seller.dashboard-seller')
        ->with('success', 'Produk berhasil diupload!');
}

    public function edit(string $id)
{
    $product = Product::with('productImages', 'category')
        ->where('user_id', auth()->id())
        ->findOrFail($id);

    $categories = Category::all();

    return view('seller.edit-product', [
        'product'    => $product,
        'categories' => $categories
    ]);
}

public function update(Request $request, string $id)
{
    $product = Product::where('user_id', auth()->id())
        ->findOrFail($id);

    $validated = $request->validate([
        'name'        => 'required|string|max:200',
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
        'category_id' => 'nullable|exists:categories,id',
        'images'      => 'nullable|array',
        'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $product->update([
        'category_id' => $validated['category_id'] ?? null,
        'name'        => $validated['name'],
        'description' => $validated['description'] ?? null,
        'price'       => $validated['price'],
    ]);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('products', 'public');
            $product->productImages()->create([
                'image_path' => $path
            ]);
        }
    }

    return redirect()->route('seller.dashboard-seller')
        ->with('success', 'Produk berhasil diupdate!');
}

public function destroy(string $id)
{
    $product = Product::where('user_id', auth()->id())
        ->findOrFail($id);

    foreach ($product->productImages as $image) {
        Storage::disk('public')->delete($image->image_path);
    }

    $product->delete();

    return redirect()->route('seller.dashboard-seller')
        ->with('success', 'Produk berhasil dihapus!');
}

}
