@extends('errors.layout')

@php
    $code = '404';
    $title = 'Halaman Tidak Ditemukan';
    $message = 'Brokoli Detektif kami sudah keliling ke seluruh garden — tapi halaman ini tetap tidak ditemukan. Mungkin produknya sudah habis, atau tautannya keliru.';
    $badge = 'Error 404';
    $hint = 'Klik di mana saja untuk menyemai benih';
    $character = 'broccoli';
@endphp

@section('character')
    @include('errors.components.broccoli')
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