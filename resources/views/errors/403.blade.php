@extends('errors.layout')

@php
    $code = '403';
    $title = 'Akses Terlarang';
    $message = 'Brokoli Detektif telah mengamankan area ini. Kamu tidak memiliki izin untuk mengakses halaman ini.';
    $badge = 'Error 403 &middot; Forbidden';
    $hint = 'Hubungi admin jika kamu merasa ini adalah kesalahan';
    $character = 'broccoli';
@endphp

@section('character')
    @include('errors.components.broccoli', ['code' => $code])
@endsection

@section('actions')
    <a class="error-btn error-btn--primary" href="/" data-error-cta>
        <svg viewBox="0 0 20 20" aria-hidden="true" width="18" height="18">
            <path d="M11 4 L5 10 L11 16" fill="none" stroke="currentColor" stroke-width="2.2"
                  stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Kembali ke Beranda
    </a>
    <a class="error-btn error-btn--ghost" href="/">Lihat Katalog</a>
@endsection
