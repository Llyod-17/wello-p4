@extends('layouts.master')

@section('konten_utama')
  <div class="success-box">
    <div class="success-icon">&#10003;</div>
    <h2 class="success-title">Pesanan Berhasil!</h2>
    <p class="success-text">Terima kasih, pesanan Anda sedang kami proses.</p>
    <p class="success-invoice">
      Nomor Pesanan: <strong>INV-2026-WL001</strong>
    </p>
    <a href="/" class="btn btn-primary">Kembali ke Beranda</a>
  </div>
@endsection