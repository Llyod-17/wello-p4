@extends('errors.layout')

@php
    $code = '503';
    $title = 'Layanan Sedang Dirawat';
    $message = 'Apel dapur sedang dalam mode pemeliharaan. Kami akan kembali dalam beberapa saat. Terima kasih atas kesabaran Anda!';
    $badge = 'Error 503 &middot; Service Unavailable';
    $hint = 'Kami sedang memperbaiki sesuatu yang lebih baik untuk Anda';
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
        Coba Lagi Nanti
    </a>
@endsection
