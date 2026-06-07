<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the products verification list.
     */
    public function verificationIndex()
    {
        $products = Product::with(['category', 'user', 'productImages'])
            ->where('status', 'menunggu_verifikasi')
            ->orderBy('created_at', 'asc')
            ->get();

        // Transform products to match the JS structure
        $productData = [];
        foreach ($products as $product) {
            $images = $product->productImages->pluck('image_url')->toArray();
            if (empty($images)) {
                $images[] = 'images/default-product.jpg';
            }

            $transformedImages = [];
            foreach ($images as $url) {
                $transformedImages[] = str_starts_with($url, 'http') ? $url : asset($url);
            }

            $productData[$product->id] = [
                'name' => $product->name,
                'price' => 'Rp' . number_format($product->price, 0, ',', '.'),
                'seller' => $product->user->name,
                'handle' => '@' . explode('@', $product->user->email)[0],
                'kategori' => $product->category->name ?? 'Umum',
                'kondisi' => 'Bekas', // Default condition as it is not explicitly stored in products table
                'diajukan' => $product->created_at->format('d M Y, H:i') . ' WIB',
                'deskripsi' => $product->description,
                'images' => $transformedImages
            ];
        }

        return view('admin.verification', compact('products', 'productData'));
    }

    /**
     * Approve the product.
     */
    public function approveProduct(Product $product)
    {
        $product->update(['status' => 'dijual']);

        // Send notification to seller
        Notification::create([
            'user_id' => $product->user_id,
            'type' => 'product_approved',
            'content' => 'Selamat! Pengajuan penjualan barang "' . $product->name . '" kamu telah disetujui.',
            'is_read' => false
        ]);

        return back()->with('success', 'Produk berhasil disetujui.');
    }

    /**
     * Reject the product.
     */
    public function rejectProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'alasan' => 'required|string|max:500'
        ]);

        $product->update(['status' => 'ditolak']);

        // Send notification to seller
        Notification::create([
            'user_id' => $product->user_id,
            'type' => 'report_created', // Map to a type known to the system notification layout
            'content' => 'Pengajuan penjualan barang "' . $product->name . '" kamu ditolak karena: ' . $validated['alasan'],
            'is_read' => false
        ]);

        return back()->with('success', 'Produk telah ditolak.');
    }
}
