@extends('layouts.master')

@section('konten_utama')
  <a href="/" class="back-link">&larr; Kembali ke Katalog</a>

  <div class="product-detail">
    {{-- Product Image --}}
    <div class="product-image">
      <img src="https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=800&h=800&fit=crop" alt="Apel Segar">
    </div>

    {{-- Product Info --}}
    <div class="product-info">
      <h2>Apel Segar</h2>
      <p class="price price-lg mb-md">Rp 35.000</p>

      <dl class="product-specs">
        <dt>Kategori</dt>
        <dd>Buah Segar</dd>

        <dt>Asal</dt>
        <dd>Malang, Jawa Timur</dd>

        <dt>Berat</dt>
        <dd>1 kg</dd>

        <dt>Kondisi</dt>
        <dd>Segar 100%</dd>
      </dl>

      <p class="text-muted mb-lg">
        Apel segar dipetik langsung dari kebun petani lokal. Kaya akan serat dan vitamin,
        cocok untuk camilan sehat atau bahan jus segar keluarga.
      </p>

      <a href="/checkout" class="btn btn-primary btn-lg">Beli Sekarang</a>
    </div>
  </div>
@endsection