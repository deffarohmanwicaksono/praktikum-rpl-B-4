@extends('layouts.app')

@section('title', 'Notifikasi - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite('resources/css/pages/notification.css')
@endpush

{{-- PAGE JS --}}
@push('scripts')
    @vite('resources/js/notification/notification.js')
@endpush

@section('content')


{{-- =============================================
     PAGE HEADER
     ============================================= --}}
<section class="page-header-section">
    <div class="page-header-left">
        <h1 class="page-title">Notifikasi</h1>
        <p class="page-subtitle">Pantau semua aktivitas terbaru di akun kamu</p>
    </div>
</section>

{{-- =============================================
     NOTIFICATION LIST PANEL
     ============================================= --}}
<div class="notification-container">
    <div class="notification-list" id="notificationList">
        @forelse ($notifications as $notif)
            <a href="{{ $notif['link'] }}" class="notif-card {{ $notif['is_unread'] ? 'unread' : '' }}" data-id="{{ $notif['id'] }}">
                
                {{-- Unread Indicator --}}
                <div class="notif-indicator-wrap">
                    @if($notif['is_unread'])
                        <div class="unread-dot"></div>
                    @endif
                </div>

                {{-- Icon --}}
                <div class="notif-icon-wrap {{ $notif['color_class'] }}">
                    <i class="bi {{ $notif['icon'] }}"></i>
                </div>

                {{-- Content --}}
                <div class="notif-content">
                    <h4 class="notif-title">{{ $notif['title'] }}</h4>
                    <p class="notif-message">{{ $notif['message'] }}</p>
                    <span class="notif-time">{{ $notif['time'] }}</span>
                </div>

                {{-- Action Chevron --}}
                <div class="notif-action">
                    <i class="bi bi-chevron-right"></i>
                </div>
            </a>
        @empty
            <div class="empty-state-card">
                <div class="empty-icon-wrap">
                    <i class="bi bi-bell-slash"></i>
                </div>
                <h3 class="no-results-title-new">Belum ada notifikasi</h3>
                <p class="no-results-desc-new">Aktivitas terbaru kamu akan muncul di sini.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection