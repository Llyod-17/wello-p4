@extends('errors.layout')

@php
    $code = '401';
    $title = 'Akses Ditolak';
    $message = 'Brokoli Detektif meminta kartu identitas! Kamu perlu login terlebih dahulu untuk mengakses area kebun ini.';
    $badge = 'Error 401 &middot; Unauthorized';
    $hint = 'Silakan masuk ke akunmu atau kembali ke beranda';
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
    <a class="error-btn error-btn--ghost" href="/login">Masuk Akun</a>
@endsection
