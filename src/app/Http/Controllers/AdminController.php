<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

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
}
