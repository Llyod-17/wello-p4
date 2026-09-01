@extends('layouts.master')

@section('konten_utama')
  <a href="/detail" class="back-link">&larr; Kembali ke Detail</a>

  <h2 class="mb-lg">Pengiriman & Pembayaran</h2>

  <div class="bg-surface rounded p-lg shadow" style="max-width: 640px;">
    <form action="/berhasil" method="GET">
      <div class="form-group">
        <label class="form-label" for="nama">Nama Lengkap</label>
        <input type="text" id="nama" class="form-input" placeholder="Masukkan nama lengkap" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="telepon">No. Telepon</label>
        <input type="tel" id="telepon" class="form-input" placeholder="08xxxxxxxxxx" required>
      </div>

      <div class="form-group">
        <label class="form-label" for="alamat">Alamat Pengiriman</label>
        <textarea id="alamat" class="form-textarea" rows="3" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan" required></textarea>
      </div>

      <div class="form-group">
        <label class="form-label" for="catatan">Catatan (Opsional)</label>
        <input type="text" id="catatan" class="form-input" placeholder="Catatan untuk kurir">
      </div>

      <hr class="divider">

      <div class="flex justify-between items-center mb-lg">
        <span class="text-muted">Total Bayar</span>
        <span class="price price-lg">Rp 35.000</span>
      </div>

      <button type="submit" class="btn btn-accent btn-block btn-lg">
        Konfirmasi Pesanan
      </button>
    </form>
  </div>
@endsection