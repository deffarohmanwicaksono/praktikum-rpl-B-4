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
    }
}
