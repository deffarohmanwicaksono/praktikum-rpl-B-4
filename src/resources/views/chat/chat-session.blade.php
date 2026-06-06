@extends('layouts.app')

@section('title', 'Sesi Chat - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite('resources/css/pages/chat-session.css')
@endpush

{{-- PAGE JS --}}
@push('scripts')
    @vite('resources/js/chat/chat-session.js')
@endpush

@section('content')
    <livewire:chat-session :chat="$chat" />
@endsection
