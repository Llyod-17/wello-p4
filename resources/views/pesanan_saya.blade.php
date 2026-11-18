@extends('layouts.master')

@section('judul', 'Pesanan Saya - Wello Vitality Grocer')

@section('konten_utama')
  <div style="margin-bottom: 24px;">
    <h1 style="font-size: 26px; font-weight: 800; color: var(--text, #191C1A); margin: 0 0 6px 0;">
      Riwayat Pesanan Saya
    </h1>
    <p style="color: var(--text-muted, #424939); font-size: 15px; margin: 0;">
      Pantau status pengiriman belanjaan sayur &amp; buah segar Anda.
    </p>
  </div>

  @if($transactions->isEmpty())
    <div class="empty-state">
      <h3>Belum Ada Pesanan</h3>
      <p>Anda belum pernah melakukan pemesanan bahan segar di Wello.</p>
      <a href="/" class="btn btn-primary" style="margin-top: 12px;">Mulai Belanja Sekarang</a>
    </div>
  @else
    <div style="display: flex; flex-direction: column; gap: 16px;">
      @foreach($transactions as $t)
        <div style="background: #FFFFFF; border: 1px solid var(--border, #C2C9B5); border-radius: 12px; padding: 20px 24px; box-shadow: 0 2px 10px rgba(27, 48, 34, 0.04);">
          <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #F2F4EF; padding-bottom: 12px; margin-bottom: 14px; flex-wrap: wrap; gap: 8px;">
            <div style="display: flex; align-items: center; gap: 12px;">
              <span style="font-family: monospace; font-weight: 700; color: #0B5ED7; font-size: 15px;">
                {{ $t->invoice_code }}
              </span>
              <span style="color: var(--text-light, #737A68); font-size: 13px;">
                {{ $t->created_at->format('d M Y, H:i') }} WIB
              </span>
            </div>

            <div>
              @if($t->status == 'Pending')
                <span style="display: inline-block; background-color: #FFF3CD; color: #856404; padding: 4px 10px; border-radius: 9999px; font-weight: 700; font-size: 12px; border: 1px solid #FFEEBA;">
                  ⏳ Menunggu Konfirmasi
                </span>
              @elseif($t->status == 'Paid')
                <span style="display: inline-block; background-color: #CFE2FF; color: #084298; padding: 4px 10px; border-radius: 9999px; font-weight: 700; font-size: 12px; border: 1px solid #B6D4FE;">
                  💳 Lunas / Dikemas
                </span>
              @elseif($t->status == 'Shipped')
                <span style="display: inline-block; background-color: #D1E7DD; color: #0F5132; padding: 4px 10px; border-radius: 9999px; font-weight: 700; font-size: 12px; border: 1px solid #BADBCC;">
                  🚚 Sedang Dikirim
                </span>
              @else
                <span style="display: inline-block; background-color: #F8D7DA; color: #842029; padding: 4px 10px; border-radius: 9999px; font-weight: 700; font-size: 12px; border: 1px solid #F5C2C7;">
                  {{ $t->status }}
                </span>
              @endif
            </div>
          </div>

          <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div>
              <h3 style="font-size: 16px; font-weight: 700; color: var(--text, #191C1A); margin: 0 0 4px 0;">
                {{ $t->product_name }}
              </h3>
              <p style="margin: 0; font-size: 13px; color: var(--text-muted, #424939);">
                Jumlah: <strong>{{ $t->quantity }}x</strong> &bull; Kurir: <strong>{{ $t->courier }}</strong>
              </p>
              @if($t->tracking_number)
                <p style="margin: 4px 0 0 0; font-size: 13px; color: var(--primary-dark, #3C6A00);">
                  No. Resi: <strong style="font-family: monospace;">{{ $t->tracking_number }}</strong>
                </p>
              @endif
            </div>

            <div style="text-align: right;">
              <p style="margin: 0; font-size: 12px; color: var(--text-light, #737A68);">Total Belanja</p>
              <p style="margin: 2px 0 10px 0; font-size: 18px; font-weight: 800; color: #BA1A1A;">
                Rp {{ number_format($t->total_amount, 0, ',', '.') }}
              </p>
              <a href="/berhasil/{{ $t->id }}" 
                 style="display: inline-block; padding: 6px 14px; background: #FFFFFF; color: var(--primary-dark, #3C6A00); border: 1.5px solid var(--primary, #7CB342); border-radius: 6px; font-size: 13px; font-weight: 700; text-decoration: none;">
                Lihat E-Invoice
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
@endsection
