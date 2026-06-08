<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Store a product report.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'reason' => 'required|string|max:1000',
        ]);

        Report::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
            'reason' => $validated['reason'],
            'status' => 'menunggu',
        ]);

        return back()->with('success', 'Laporan produk berhasil dikirim. Terima kasih atas laporan Anda.');
    }
}
