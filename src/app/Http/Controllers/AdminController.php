<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Notification;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with real statistics and growth datasets.
     */
    public function dashboardIndex()
    {
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();

        // Calculate growth trends over the last 12 months
        $months = [];
        $userCounts = [];
        $productCounts = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabel = $date->format("M 'y");
            $months[] = $monthLabel;

            // Cumulative counts up to the end of that month
            $userCounts[] = User::where('created_at', '<=', $date->endOfMonth())->count();
            $productCounts[] = Product::where('created_at', '<=', $date->endOfMonth())->count();
        }

        $chartData = [
            3 => [
                'labels' => array_slice($months, -3),
                'user'   => array_slice($userCounts, -3),
                'produk' => array_slice($productCounts, -3),
            ],
            6 => [
                'labels' => array_slice($months, -6),
                'user'   => array_slice($userCounts, -6),
                'produk' => array_slice($productCounts, -6),
            ],
            12 => [
                'labels' => $months,
                'user'   => $userCounts,
                'produk' => $productCounts,
            ],
        ];

        return view('admin.dashboard-admin', compact(
            'totalUsers',
            'totalProducts',
            'totalTransactions',
            'chartData'
        ));
    }

    /**
     * Display admin reports index.
     */
    public function reportsIndex()
    {
        $reports = Report::with(['user', 'product.productImages', 'product.user', 'product.category'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Transform reports to match the JS structure
        $reportData = [];
        foreach ($reports as $report) {
            $images = [];
            if ($report->product) {
                $images = $report->product->productImages->pluck('image_url')->toArray();
            }
            if (empty($images)) {
                $images[] = 'images/default-product.jpg';
            }

            $transformedImages = [];
            foreach ($images as $url) {
                $transformedImages[] = str_starts_with($url, 'http') ? $url : asset($url);
            }

            $peringatan = null;
            if ($report->status === 'ditindaklanjuti' && $report->product) {
                $peringatan = Notification::where('user_id', $report->product->user_id)
                    ->where('content', 'like', '%' . $report->product->name . '%')
                    ->latest()
                    ->value('content');
            }

            $reportData[$report->id] = [
                'id' => $report->id,
                'productName' => $report->product->name ?? 'Produk dihapus',
                'category' => $report->product->category->name ?? 'Umum',
                'price' => 'Rp' . number_format($report->product->price ?? 0, 0, ',', '.'),
                'condition' => 'Bekas',
                'sellerName' => $report->product->user->name ?? 'Seller',
                'sellerHandle' => '@' . explode('@', $report->product->user->email ?? 'seller')[0],
                'pelapor' => $report->user->name . ', @' . explode('@', $report->user->email)[0],
                'dilaporkan' => $report->created_at->format('d M Y, H:i') . ' WIB',
                'alasan' => $report->reason,
                'status' => $report->status,
                'peringatan' => $peringatan,
                'images' => $transformedImages
            ];
        }

        return view('admin.reports', compact('reports', 'reportData'));
    }

    /**
     * Take action on a report (send warning to seller).
     */
    public function actionReport(Request $request, Report $report)
    {
        $validated = $request->validate([
            'peringatan' => 'required|string|max:1000'
        ]);

        $report->load('product.user');

        DB::transaction(function () use ($report, $validated) {
            $report->update(['status' => 'ditindaklanjuti']);

            if ($report->product) {
                // Send notification (warning) to seller
                Notification::create([
                    'user_id' => $report->product->user_id,
                    'type' => 'report_created', // Maps to warning icon style
                    'content' => $validated['peringatan'],
                    'is_read' => false
                ]);
            }
        });

        return back()->with('success', 'Peringatan berhasil dikirim to seller.');
    }

    /**
     * Reject a report.
     */
    public function rejectReport(Report $report)
    {
        $report->update(['status' => 'ditolak']);

        return back()->with('success', 'Laporan berhasil ditolak.');
    /**
     * Display the list of users.
     */
    public function usersIndex()
    {
        $usersQuery = User::withCount(['products'])
            ->with(['products.reviews'])
            ->get();

        $users = [];
        foreach ($usersQuery as $user) {
            $roles = array_map('ucfirst', $user->roles ?? []);
            
            // Calculate rating based on products
            $totalRating = 0;
            $totalReviews = 0;
            
            foreach ($user->products as $product) {
                $reviewsCount = $product->reviews->count();
                if ($reviewsCount > 0) {
                    $totalRating += $product->reviews->sum('rating');
                    $totalReviews += $reviewsCount;
                }
            }
            
            $rating = $totalReviews > 0 ? round($totalRating / $totalReviews, 1) : 0;
            
            // Calculate transactions (simplified: as seller vs buyer)
            $transactions = Transaction::where(function($q) use ($user) {
                $q->where('buyer_id', $user->id)
                  ->orWhereHas('product', function($q2) use ($user) {
                      $q2->where('user_id', $user->id);
                  });
            })->where('status', 'selesai')->count();

            $productsSold = Transaction::whereHas('product', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('status', 'selesai')->sum('quantity');

            $statusClass = $user->status === 'aktif' ? 'status-aktif' : 'status-diblokir';

            $users[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => empty($roles) ? ['Buyer'] : $roles,
                'status' => ucfirst($user->status ?? 'Aktif'),
                'status_class' => $statusClass,
                'joined' => $user->created_at ? $user->created_at->format('d M Y') : '-',
                'phone' => $user->phone_number ?? '-',
                'products_sold' => (int)$productsSold,
                'transactions' => $transactions,
                'rating' => $rating,
                'reviews' => $totalReviews
            ];
        }

        return view('admin.users', compact('users'));
    }

    /**
     * Toggle user status (aktif/diblokir)
     */
    public function toggleUserStatus(User $user)
    {
        $newStatus = $user->status === 'aktif' ? 'diblokir' : 'aktif';
        $user->update(['status' => $newStatus]);
        return back()->with('success', 'Status user berhasil diperbarui menjadi ' . ucfirst($newStatus) . '.');
    }

    /**
     * Display all products.
     */
    public function productsIndex()
    {
        $productsQuery = Product::with(['user', 'category', 'productImages'])
            ->orderBy('created_at', 'desc')
            ->get();

        $products = [];
        foreach ($productsQuery as $product) {
            $images = $product->productImages->pluck('image_url')->toArray();
            $mainImage = empty($images) ? asset('images/default-product.jpg') : (str_starts_with($images[0], 'http') ? $images[0] : asset($images[0]));
            
            $statusClass = '';
            switch ($product->status) {
                case 'dijual': $statusClass = 'status-dijual'; break;
                case 'menunggu_verifikasi': $statusClass = 'status-menunggu'; break;
                case 'ditolak': $statusClass = 'status-ditolak'; break;
                case 'sold_out': $statusClass = 'status-sold-out'; break;
            }
            
            $catClass = '';
            $catName = strtolower($product->category->name ?? '');
            if (str_contains($catName, 'elektronik')) $catClass = 'cat-elektronik';
            elseif (str_contains($catName, 'buku')) $catClass = 'cat-buku';
            
            $conditionMap = [
                'bekas_seperti_baru' => 'Bekas Seperti Baru',
                'bekas_baik' => 'Bekas Baik',
                'bekas_layak_pakai' => 'Bekas Layak Pakai'
            ];

            $products[] = [
                'id' => $product->id,
                'image' => $mainImage,
                'detail_image' => $mainImage,
                'images' => array_map(fn($url) => str_starts_with($url, 'http') ? $url : asset($url), empty($images) ? ['images/default-product.jpg'] : $images),
                'name' => $product->name,
                'badge' => $product->category->name ?? 'Umum',
                'category_class' => $catClass,
                'seller_name' => $product->user->name,
                'seller_handle' => '@' . explode('@', $product->user->email)[0],
                'price' => 'Rp' . number_format($product->price, 0, ',', '.'),
                'category' => $product->category->name ?? 'Umum',
                'status' => ucwords(str_replace('_', ' ', $product->status)),
                'status_class' => $statusClass,
                'condition' => $conditionMap[$product->condition] ?? 'Bekas Baik',
                'description' => $product->description,
                'date' => $product->created_at ? $product->created_at->format('d M Y') : '-'
            ];
        }

        return view('admin.products', compact('products'));
    }

    /**
     * Delete product.
     */
    public function deleteProduct(Product $product)
    {
        try {
            $product->delete();
            return back()->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Produk tidak dapat dihapus karena terkait dengan transaksi atau data lain.');
        }
    }

    /**
     * Display transactions.
     */
    public function transactionsIndex()
    {
        $transactionsQuery = Transaction::with(['product.user', 'product.productImages', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->get();

        $transactions = [];
        foreach ($transactionsQuery as $trx) {
            $product = $trx->product;
            if (!$product) continue;
            
            $seller = $product->user;
            $buyer = $trx->buyer;
            
            $images = $product->productImages->pluck('image_url')->toArray();
            $mainImage = empty($images) ? asset('images/default-product.jpg') : (str_starts_with($images[0], 'http') ? $images[0] : asset($images[0]));
            
            $statusClass = '';
            switch ($trx->status) {
                case 'selesai': $statusClass = 'status-selesai'; break;
                case 'gagal': $statusClass = 'status-gagal'; break;
                case 'menunggu_pembayaran': $statusClass = 'status-menunggu'; break;
                case 'dibayar': $statusClass = 'status-menunggu'; break;
            }

            $proofUrl = $trx->payment_proof ? (str_starts_with($trx->payment_proof, 'http') ? $trx->payment_proof : asset($trx->payment_proof)) : null;

            $transactions[] = [
                'id' => $trx->id,
                'buyer_name' => $buyer->name ?? 'Unknown',
                'buyer_handle' => '@' . explode('@', $buyer->email ?? 'unknown')[0],
                'product_image' => $mainImage,
                'payment_receipt' => $proofUrl,
                'product_name' => $product->name,
                'seller_name' => $seller->name ?? 'Unknown',
                'seller_handle' => '@' . explode('@', $seller->email ?? 'unknown')[0],
                'price' => 'Rp' . number_format($trx->total_price, 0, ',', '.'),
                'method_text' => $trx->payment_method ?? 'Transfer Bank',
                'status' => ucwords(str_replace('_', ' ', $trx->status)),
                'status_class' => $statusClass,
                'date' => $trx->created_at ? $trx->created_at->format('d M Y') : '-',
                'time' => $trx->created_at ? $trx->created_at->format('H:i') . ' WIB' : '-',
                'date_raw' => $trx->created_at ? $trx->created_at->format('Y-m-d') : '-'
            ];
        }

        return view('admin.transactions', compact('transactions'));
    }
}
