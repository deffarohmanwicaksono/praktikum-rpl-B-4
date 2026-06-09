<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $rawNotifications = Notification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $notifications = $rawNotifications->map(function ($notif) {
            $data = [
                'id' => $notif->id,
                'type' => $notif->type,
                'message' => $notif->content,
                'time' => $notif->created_at ? $notif->created_at->diffForHumans() : '-',
                'is_unread' => !$notif->is_read,
                'link' => '#', // Default
            ];

            switch ($notif->type) {
                case 'product_approved':
                    $data['title'] = 'Produk Disetujui';
                    $data['icon'] = 'bi-clipboard-check';
                    $data['color_class'] = 'icon-blue';
                    $data['link'] = route('seller.dashboard-seller');
                    break;
                case 'product_rejected':
                    $data['title'] = 'Produk Ditolak';
                    $data['icon'] = 'bi-x-circle';
                    $data['color_class'] = 'icon-red';
                    $data['link'] = route('seller.dashboard-seller');
                    break;
                case 'purchase_link':
                    $data['title'] = 'Link Pembelian';
                    $data['icon'] = 'bi-link-45deg';
                    $data['color_class'] = 'icon-blue';
                    $data['link'] = route('chat.list');
                    break;
                case 'report_created':
                    $data['title'] = 'Peringatan Laporan';
                    $data['icon'] = 'bi-exclamation-triangle';
                    $data['color_class'] = 'icon-orange';
                    $data['link'] = route('seller.dashboard-seller');
                    break;
                case 'message':
                    $data['title'] = 'Pesan Baru';
                    $data['icon'] = 'bi-chat-dots';
                    $data['color_class'] = 'icon-blue';
                    $data['link'] = route('chat.list');
                    break;
                case 'payment':
                    $data['title'] = 'Pembayaran Diterima';
                    $data['icon'] = 'bi-wallet2';
                    $data['color_class'] = 'icon-blue';
                    $data['link'] = route('history.sales-history');
                    break;
                case 'sold':
                    $data['title'] = 'Transaksi Selesai';
                    $data['icon'] = 'bi-bag-check';
                    $data['color_class'] = 'icon-blue';
                    $data['link'] = route('history.purchase-history');
                    break;
                default:
                    $data['title'] = 'Notifikasi';
                    $data['icon'] = 'bi-bell';
                    $data['color_class'] = 'icon-blue';
                    break;
            }

            return $data;
        });

        // Mark all as read when viewed
        Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('notification.notification', compact('notifications'));
    }
}
