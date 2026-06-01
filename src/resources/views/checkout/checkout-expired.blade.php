@extends('layouts.app')

@section('title', 'Link Tidak Valid - SeMart')

@section('content')
<div style="display: flex; align-items: center; justify-content: center; min-height: 60vh;">
    <div style="text-align: center; max-width: 400px;">
        <div style="font-size: 4rem; margin-bottom: 1rem;">
            <i class="bi bi-exclamation-triangle-fill" style="color: #e74c3c;"></i>
        </div>
        <h2 style="margin-bottom: 0.5rem; color: #1a1a2e;">Link Tidak Valid</h2>
        <p style="color: #6c757d; margin-bottom: 1.5rem;">
            {{ $message }}
        </p>
        <a href="{{ route('chat.list') }}" class="btn" style="background-color: var(--primary-blue); color: white; border-radius: 8px; padding: 10px 20px; text-decoration: none; font-weight: 600;">
            <i class="bi bi-chat-dots"></i> Kembali ke Chat
        </a>
    </div>
</div>
@endsection
