<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $query = Product::with(['productImages', 'category'])->where('status', 'dijual');

        if ($request->filled('category') && $request->category !== 'semua') {
            $catMap = [
                'elektronik' => 1,
                'buku'       => 2,
                'perabot'    => 3,
                'pakaian'    => 4,
                'olahraga'   => 5,
                'hobi'       => 6,
                'kecantikan' => 7,
                'lainnya'    => 8,
            ];

            if (isset($catMap[$request->category])) {
                $query->where('category_id', $catMap[$request->category]);
            }
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'terlama':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'termurah':
                    $query->orderBy('price', 'asc');
                    break;
                case 'termahal':
                    $query->orderBy('price', 'desc');
                    break;
                case 'terbaru':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->get();

        $wishlistedIds = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        return view('home.home', compact('products', 'wishlistedIds'));
    }

    public function show(string $id)
    {
        $product = Product::with(['productImages', 'user', 'category'])
            ->findOrFail($id);

        $wishlistedIds = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        return view('products.detail-product', [
            'product'       => $product,
            'wishlistedIds' => $wishlistedIds,
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('q');
        $query   = Product::with(['productImages', 'category'])->where('status', 'dijual');

        if ($request->filled('category') && $request->category !== 'semua') {
            $catMap = [
                'elektronik' => 1,
                'buku'       => 2,
                'perabot'    => 3,
                'pakaian'    => 4,
                'olahraga'   => 5,
                'hobi'       => 6,
                'kecantikan' => 7,
                'lainnya'    => 8,
            ];

            if (isset($catMap[$request->category])) {
                $query->where('category_id', $catMap[$request->category]);
            }

            $keyword = null;
        } else {
            if ($request->filled('q')) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                      ->orWhere('description', 'like', "%{$keyword}%");
                });
            }
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'terlama':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'termurah':
                    $query->orderBy('price', 'asc');
                    break;
                case 'termahal':
                    $query->orderBy('price', 'desc');
                    break;
                case 'terbaru':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->get();

        $wishlistedIds = Auth::check()
            ? Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray()
            : [];

        return view('products.search', [
            'keyword'       => $keyword,
            'products'      => $products,
            'wishlistedIds' => $wishlistedIds,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('seller.upload-product', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:200',
            'description' => 'nullable|string|max:1000',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'condition'   => 'required|in:bekas_seperti_baru,bekas_baik,bekas_layak_pakai',
            'images'      => 'required|array|min:1',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::create([
            'user_id'     => auth()->id(),
            'category_id' => $validated['category_id'] ?? null,
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price'       => $validated['price'],
            'condition'   => $validated['condition'],
            'status'      => 'menunggu_verifikasi',
        ]);

        $user = auth()->user();
        $roles = $user->roles ?? [];
        if (!in_array('seller', $roles)) {
            $roles[] = 'seller';
            $user->update(['roles' => $roles]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->productImages()->create(['image_url' => $path]);
            }
        }

        return redirect()->route('seller.dashboard-seller')->with('success', 'Produk berhasil diupload!');
    }

    public function edit(string $id)
    {
        $product = Product::with('productImages', 'category')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        $categories = Category::all();
        return view('seller.edit-product', ['product' => $product, 'categories' => $categories]);
    }

    public function update(Request $request, string $id)
    {
        $product = Product::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'name'              => 'required|string|max:200',
            'description'       => 'nullable|string|max:1000',
            'price'             => 'required|numeric|min:0',
            'category_id'       => 'nullable|exists:categories,id',
            'condition'         => 'required|in:bekas_seperti_baru,bekas_baik,bekas_layak_pakai',
            'existing_images'   => 'nullable|array',
            'existing_images.*' => 'exists:product_images,id',
            'images'            => 'nullable|array',
            'images.*'          => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if (empty($validated['existing_images']) && !$request->hasFile('images')) {
            return back()->withErrors(['images' => 'Produk minimal harus memiliki 1 foto.'])->withInput();
        }

        $product->update([
            'category_id' => $validated['category_id'] ?? null,
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price'       => $validated['price'],
            'condition'   => $validated['condition'],
        ]);

        // Delete images that are no longer present
        $existingImageIds = $validated['existing_images'] ?? [];
        $imagesToDelete = $product->productImages()->whereNotIn('id', $existingImageIds)->get();
        foreach ($imagesToDelete as $img) {
            Storage::disk('public')->delete($img->image_url);
            $img->delete();
        }

        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $product->productImages()->create(['image_url' => $path]);
            }
        }

        return redirect()->route('seller.dashboard-seller')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $product = Product::where('user_id', auth()->id())->findOrFail($id);

        foreach ($product->productImages as $image) {
            Storage::disk('public')->delete($image->image_url);
        }

        $product->delete();

        return redirect()->route('seller.dashboard-seller')->with('success', 'Produk berhasil dihapus!');
    }
    public function sellerDashboard()
    {
        $products = Product::with('productImages')->where('user_id', auth()->id())->get();

        $sellerProducts = $products->map(function ($product) {
            $statusMap = [
                'menunggu_verifikasi' => ['label' => 'Menunggu', 'class' => 'status-menunggu'],
                'dijual' => ['label' => 'Dijual', 'class' => 'status-dijual'],
                'sold_out' => ['label' => 'Sold Out', 'class' => 'status-sold-out'],
                'ditolak' => ['label' => 'Ditolak', 'class' => 'status-ditolak'],
            ];

            $statusData = $statusMap[$product->status] ?? ['label' => $product->status, 'class' => ''];
            
            $imageUrl = $product->productImages->first()->image_url ?? 'images/default-product.jpg';
            if (!str_starts_with($imageUrl, 'http')) {
                $imageUrl = asset($imageUrl);
            }

            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                'status' => $statusData['label'],
                'status_class' => $statusData['class'],
                'image' => $imageUrl,
            ];
        });

        return view('seller.dashboard-seller', compact('sellerProducts'));
    }

}
