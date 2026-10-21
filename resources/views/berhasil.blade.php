@extends('layouts.master')

@section('judul', 'Transaksi Berhasil - Invoice ' . $transaction->invoice_code . ' - Wello')

@section('konten_utama')
  <div style="max-width: 680px; margin: 16px auto 40px auto; background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border, #C2C9B5); box-shadow: 0 4px 20px rgba(27, 48, 34, 0.06); padding: 40px; box-sizing: border-box;">

    {{-- Header Perayaan Transaksi Sukses --}}
    <div style="text-align: center; border-bottom: 2px dashed #E2ECD4; padding-bottom: 24px; margin-bottom: 28px;">
      <div style="width: 72px; height: 72px; border-radius: 50%; background: #EAEFD9; color: var(--primary-dark, #3C6A00); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px; box-shadow: 0 4px 14px rgba(60, 106, 0, 0.1);">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" width="36" height="36">
          <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
      </div>
      <h1 style="font-size: 26px; font-weight: 800; color: var(--primary-dark, #3C6A00); margin: 0 0 8px 0; letter-spacing: -0.02em;">
        Transaksi Berhasil Dicatat!
      </h1>
      <p style="color: var(--text-muted, #424939); font-size: 15px; margin: 0; line-height: 1.5;">
        Terima kasih <strong style="color: var(--text, #191C1A);">{{ $transaction->customer_name }}</strong>, pesanan sayur/buah segarmu sedang disiapkan untuk dikirim.
      </p>
    </div>

    {{-- Detail Invoice Table --}}
    <div style="margin-bottom: 28px;">
      <h3 style="font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-light, #737A68); margin: 0 0 16px 0;">
        Bukti Transaksi Resmi (Invoice)
      </h3>

      <table style="width: 100%; border-collapse: collapse; font-size: 14.5px;">
        <tr style="border-bottom: 1px solid #F2F4EF;">
          <td style="padding: 12px 0; color: var(--text-muted, #424939);">Nomor Invoice / Resi</td>
          <td style="padding: 12px 0; text-align: right; font-weight: 700; color: #0B5ED7; font-family: monospace; font-size: 15px;">
            {{ $transaction->invoice_code }}
          </td>
        </tr>

        <tr style="border-bottom: 1px solid #F2F4EF;">
          <td style="padding: 12px 0; color: var(--text-muted, #424939);">Waktu Transaksi</td>
          <td style="padding: 12px 0; text-align: right; font-weight: 600; color: var(--text, #191C1A);">
            {{ $transaction->created_at->format('d M Y, H:i') }} WIB
          </td>
        </tr>

        <tr style="border-bottom: 1px solid #F2F4EF;">
          <td style="padding: 12px 0; color: var(--text-muted, #424939);">Produk yang Dipesan</td>
          <td style="padding: 12px 0; text-align: right; font-weight: 700; color: var(--text, #191C1A);">
            {{ $transaction->product_name }} <span style="color: var(--primary-dark, #3C6A00);">({{ $transaction->quantity }}x)</span>
          </td>
        </tr>

        <tr style="border-bottom: 1px solid #F2F4EF;">
          <td style="padding: 12px 0; color: var(--text-muted, #424939);">Penerima & WhatsApp</td>
          <td style="padding: 12px 0; text-align: right; font-weight: 600; color: var(--text, #191C1A);">
            {{ $transaction->customer_name }} <span style="color: var(--text-light, #737A68); font-size: 13px;">({{ $transaction->customer_phone }})</span>
          </td>
        </tr>

        <tr style="border-bottom: 1px solid #F2F4EF;">
          <td style="padding: 12px 0; color: var(--text-muted, #424939); vertical-align: top;">Alamat Pengiriman</td>
          <td style="padding: 12px 0; text-align: right; color: var(--text, #191C1A); max-width: 320px; line-height: 1.4;">
            {{ $transaction->customer_address }}
          </td>
        </tr>

        <tr style="border-bottom: 1px solid #F2F4EF;">
          <td style="padding: 12px 0; color: var(--text-muted, #424939);">Kurir & Ongkos Kirim</td>
          <td style="padding: 12px 0; text-align: right; font-weight: 600; color: var(--text, #191C1A);">
            {{ $transaction->courier }} <span style="color: var(--text-muted, #424939);">(Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }})</span>
          </td>
        </tr>

        <tr style="border-bottom: 1px solid #E2ECD4;">
          <td style="padding: 12px 0; color: var(--text-muted, #424939);">Status Pesanan</td>
          <td style="padding: 12px 0; text-align: right;">
            <span style="display: inline-block; background-color: #FFF3CD; color: #856404; padding: 4px 12px; border-radius: 9999px; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.04em;">
              {{ $transaction->status }}
            </span>
          </td>
        </tr>

        <tr>
          <td style="padding: 20px 0 0 0; font-size: 16px; font-weight: 800; color: var(--text, #191C1A);">
            TOTAL DIBAYAR:
          </td>
          <td style="padding: 20px 0 0 0; text-align: right; font-size: 24px; font-weight: 800; color: #BA1A1A;">
            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
          </td>
        </tr>
      </table>
    </div>

    {{-- Tombol Aksi --}}
    <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; margin-top: 32px;">
      <a href="/"
         style="display: inline-flex; align-items: center; gap: 8px; background-color: var(--primary, #7CB342); color: #FFFFFF; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 15px; transition: all 0.2s ease; box-shadow: 0 4px 14px rgba(124, 179, 66, 0.3);"
         onmouseover="this.style.backgroundColor='var(--primary-dark, #3C6A00)'"
         onmouseout="this.style.backgroundColor='var(--primary, #7CB342)'">
        <svg viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
          <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
        </svg>
        <span>Belanja Produk Lain</span>
      </a>

      <button type="button" onclick="window.print()"
              style="display: inline-flex; align-items: center; gap: 8px; background-color: transparent; color: var(--text-muted, #424939); padding: 12px 20px; border: 1.5px solid var(--border, #C2C9B5); border-radius: 8px; font-weight: 600; font-size: 15px; cursor: pointer; transition: all 0.2s ease;"
              onmouseover="this.style.borderColor='var(--text, #191C1A)'; this.style.color='var(--text, #191C1A)'"
              onmouseout="this.style.borderColor='var(--border, #C2C9B5)'; this.style.color='var(--text-muted, #424939)'">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
          <path d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/>
          <path d="M6 14h12v8H6z"/>
        </svg>
        <span>Cetak Invoice</span>
      </button>
    </div>

  </div>
@endsection
