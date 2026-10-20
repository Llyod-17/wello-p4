@extends('errors.layout')

@php
    $code = '500';
    $title = 'Server Sedang Korslet';
    $message = 'Apel dapur kami kebakaran! Tim technical kami sedang mencoba memadamkan apinya. Silakan coba lagi beberapa saat.';
    $badge = 'Error 500 &middot; Internal Server Error';
    $hint = 'Klik apel untuk membantu memadamkan api dengan air!';
    $character = 'apple';
@endphp

@section('character')
    @include('errors.components.apple', ['code' => $code])
@endsection

@section('actions')
    <a class="error-btn error-btn--primary" href="/" data-error-cta>
        <svg viewBox="0 0 20 20" aria-hidden="true" width="18" height="18">
            <path d="M11 4 L5 10 L11 16" fill="none" stroke="currentColor" stroke-width="2.2"
                  stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Kembali ke Beranda
    </a>
@endsection
