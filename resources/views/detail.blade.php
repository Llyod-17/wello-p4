@extends('layouts.master')
@section('konten_utama')

<!-- 1. FITUR BREADCRUMB NAVIGATION (Standar Industri E-Commerce) -->
<!-- Mencegah Dead-End dan memandu orientasi pengguna -->
<div style="margin-bottom: 25px; font-size: 14px; color: #666;">
    <a href="/" style="color: #0B5ED7; text-decoration: none;">Katalog Utama</a>
    <span style="margin: 0 10px;">/</span>
    <span style="color: #333; font-weight: bold;">{{ $product->name }}</span>
</div>

<div style="display: flex; margin-top: 20px; background-color: white; padding: 20px; border-radius: 8px; border: 1px solid #ccc;">

    <!-- BAGIAN KIRI: GAMBAR PRODUK -->
    <div style="width: 40%; text-align: center;">
        @if($product->image)
            <img src="{{ asset('assets/images/' . $product->image) }}" width="100%" style="border-radius: 8px;">
        @else
            <div style="background:#eee; height:300px; line-height: 300px; border-radius: 8px;">
                Tanpa Gambar
            </div>
        @endif
    </div>

    <!-- BAGIAN KANAN: SPESIFIKASI DARI DATABASE -->
    <div style="width: 60%; padding-left: 40px;">
        <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 8px;">
            <span style="font-size: 12px; font-weight: 700; text-transform: uppercase; color: #3C6A00; background: #EAEFD9; padding: 4px 10px; border-radius: 9999px;">
                {{ $product->category ?? 'Umum' }}
            </span>
            <span style="font-size: 13px; font-weight: 600; color: {{ $product->stock > 0 ? '#424939' : '#BA1A1A' }};">
                @if($product->stock > 0)
                    Tersedia: <strong>{{ $product->stock }}</strong> unit
                @else
                    <strong>Stok Habis</strong>
                @endif
            </span>
        </div>

        <h1 style="margin-top: 0; font-size: 28px;">{{ $product->name }}</h1>

        <h2 style="color: #7CB342; border-bottom: 1px solid #eee; padding-bottom: 15px;">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </h2>

        <p style="font-weight: bold;">Spesifikasi & Deskripsi:</p>

        <div style="line-height: 1.6; color: #555; text-align: justify;">
            <!-- nl2br untuk membaca format spasi 'Enter' dari database -->
            {!! nl2br(e($product->description)) !!}
        </div>

        <!-- Tombol Keranjang: Bawa ID Produk untuk P7 Nanti -->
        <div style="margin-top: 30px;">
            @if($product->stock > 0)
                <a href="/checkout/{{ $product->id }}"
                   style="display: inline-block; background-color: #7CB342; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold;">
                    Beli & Checkout Sekarang
                </a>
            @else
                <button type="button" disabled
                        style="display: inline-block; background-color: #E0E3DB; color: #8C9382; padding: 12px 25px; border-radius: 8px; font-weight: bold; border: none; cursor: not-allowed;">
                    Produk Sedang Habis
                </button>
            @endif
        </div>
    </div>
</div>

@endsection
