@extends('layouts.master')

@section('judul', 'Keranjang Belanja - Wello Vitality Grocer')

@section('konten_utama')
  <!-- Breadcrumb -->
  <nav class="breadcrumb mb-md" aria-label="Breadcrumb">
    <a href="/" style="color: var(--primary-dark, #3C6A00); text-decoration: none; font-weight: 500;">Katalog</a>
    <span style="color: var(--text-light, #737A68); margin: 0 8px;">/</span>
    <span style="color: var(--text-muted, #424939); font-weight: 600;">Keranjang Belanja</span>
  </nav>

  <!-- Flash Message -->
  @if(session('success'))
    <div style="background-color: #EAEFD9; color: var(--primary-dark, #3C6A00); padding: 14px 18px; border-radius: 10px; border: 1px solid #C2C9B5; margin-bottom: 24px; font-weight: 700; display: flex; align-items: center; justify-content: space-between;">
      <span>✓ {{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div style="background-color: #FFF4F2; color: #BA1A1A; padding: 14px 18px; border-radius: 10px; border: 1px solid #FFDAD6; margin-bottom: 24px; font-weight: 700;">
      <span>✕ {{ session('error') }}</span>
    </div>
  @endif

  <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
    <div>
      <h1 style="font-size: 28px; font-weight: 800; color: var(--text, #191C1A); margin: 0 0 6px 0; letter-spacing: -0.02em;">
        🛒 Keranjang Belanja Anda
      </h1>
      <p style="color: var(--text-muted, #424939); font-size: 15px; margin: 0;">
        Periksa kembali produk segar pilihan Anda sebelum melanjutkan ke pengiriman.
      </p>
    </div>

    @if(!$cartItems->isEmpty())
      <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Kosongkan semua isi keranjang?');">
        @csrf
        <button type="submit" 
                style="background: transparent; color: #BA1A1A; border: 1px solid #FFDAD6; padding: 8px 14px; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer;">
          Kosongkan Keranjang
        </button>
      </form>
    @endif
  </div>

  @if($cartItems->isEmpty())
    <div class="empty-state" style="text-align: center; padding: 60px 20px; background: #FFFFFF; border-radius: 16px; border: 1px solid var(--border, #C2C9B5);">
      <div style="font-size: 54px; margin-bottom: 12px;">🛒</div>
      <h3 style="font-size: 20px; font-weight: 800; color: var(--text, #191C1A); margin: 0 0 8px 0;">
        Keranjang Belanja Anda Kosong
      </h3>
      <p style="color: var(--text-muted, #424939); font-size: 15px; max-width: 420px; margin: 0 auto 20px auto;">
        Anda belum menambahkan buah atau sayur segar ke dalam keranjang.
      </p>
      <a href="/" class="btn btn-primary" style="padding: 12px 24px; font-weight: 700; text-decoration: none; border-radius: 8px; display: inline-block;">
        Jelajahi Produk Segar
      </a>
    </div>
  @else
    <div style="display: flex; gap: 28px; align-items: flex-start; flex-wrap: wrap;">

      <!-- DAFTAR ITEM KERANJANG (KOLOM KIRI) -->
      <div style="flex: 1 1 580px; display: flex; flex-direction: column; gap: 14px;">
        @foreach($cartItems as $item)
          <div style="background: #FFFFFF; border: 1px solid var(--border, #C2C9B5); border-radius: 14px; padding: 20px; box-shadow: 0 2px 10px rgba(27, 48, 34, 0.04); display: flex; gap: 18px; align-items: center; flex-wrap: wrap;">
            
            <!-- Gambar Produk -->
            <div style="width: 80px; height: 80px; flex-shrink: 0; background: #F5F7F2; border-radius: 10px; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border, #C2C9B5);">
              @if($item->product->image)
                <img src="{{ asset('assets/images/' . $item->product->image) }}" alt="{{ $item->product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
              @else
                <span style="font-size: 26px;">🌿</span>
              @endif
            </div>

            <!-- Detail Info Produk -->
            <div style="flex: 1 1 200px;">
              <span style="font-size: 11px; font-weight: 700; color: var(--primary-dark, #3C6A00); text-transform: uppercase;">
                {{ $item->product->category ?? 'Umum' }}
              </span>
              <h3 style="font-size: 16px; font-weight: 700; color: var(--text, #191C1A); margin: 2px 0 4px 0;">
                <a href="/detail/{{ $item->product->id }}" style="color: inherit; text-decoration: none;">
                  {{ $item->product->name }}
                </a>
              </h3>
              <p style="margin: 0; font-size: 14px; font-weight: 700; color: var(--primary-dark, #3C6A00);">
                Rp {{ number_format($item->product->price, 0, ',', '.') }}
                <span style="font-size: 12px; font-weight: 400; color: var(--text-light, #737A68);">/ pcs (Sisa stok: {{ $item->product->stock }})</span>
              </p>
            </div>

            <!-- Form Update Qty -->
            <div style="display: flex; align-items: center; gap: 8px;">
              <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: flex; align-items: center; gap: 6px;">
                @csrf
                <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}" 
                        style="width: 32px; height: 32px; border: 1px solid var(--border, #C2C9B5); background: #F8FAF5; border-radius: 6px; font-weight: 800; cursor: pointer;"
                        {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>

                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                       style="width: 52px; text-align: center; padding: 6px 4px; border: 1.5px solid var(--border, #C2C9B5); border-radius: 6px; font-weight: 700;"
                       onchange="this.form.submit()">

                <button type="submit" name="quantity" value="{{ min($item->product->stock, $item->quantity + 1) }}" 
                        style="width: 32px; height: 32px; border: 1px solid var(--border, #C2C9B5); background: #F8FAF5; border-radius: 6px; font-weight: 800; cursor: pointer;"
                        {{ $item->quantity >= $item->product->stock ? 'disabled' : '' }}>+</button>
              </form>
            </div>

            <!-- Subtotal Item & Tombol Hapus -->
            <div style="text-align: right; min-width: 110px;">
              <div style="font-size: 16px; font-weight: 800; color: #BA1A1A; margin-bottom: 6px;">
                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
              </div>
              <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini?');">
                @csrf
                <button type="submit" 
                        style="background: transparent; color: #BA1A1A; border: none; font-size: 12px; font-weight: 700; cursor: pointer; text-decoration: underline;">
                  Hapus
                </button>
              </form>
            </div>

          </div>
        @endforeach
      </div>

      <!-- RINGKASAN BELANJA (KOLOM KANAN) -->
      <div style="flex: 1 1 340px; background: #FFFFFF; border: 1px solid var(--border, #C2C9B5); border-radius: 16px; padding: 28px; box-shadow: 0 4px 20px rgba(27, 48, 34, 0.05); position: sticky; top: 90px;">
        <h3 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 700; color: var(--text, #191C1A); border-bottom: 1.5px solid #F2F4EF; padding-bottom: 12px;">
          Ringkasan Belanja
        </h3>

        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14.5px; color: var(--text-muted, #424939);">
          <span>Total Item</span>
          <span style="font-weight: 700; color: var(--text, #191C1A);">{{ $totalItems }} Pcs</span>
        </div>

        <div style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 14.5px; color: var(--text-muted, #424939);">
          <span>Total Harga Produk</span>
          <span style="font-weight: 800; color: var(--text, #191C1A); font-size: 16px;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>

        <div style="background: #F8FAF5; border-radius: 10px; padding: 12px; margin-bottom: 20px; font-size: 12px; color: var(--text-light, #737A68); border: 1px dashed var(--border, #C2C9B5);">
          * Ongkos kirim dan kupon diskon akan dihitung pada langkah formulir checkout berikutnya.
        </div>

        <a href="{{ route('cart.checkout') }}" 
           style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; background: var(--primary, #7CB342); color: #FFFFFF; padding: 14px 20px; font-size: 16px; font-weight: 700; text-decoration: none; border-radius: 10px; box-sizing: border-box; text-align: center; box-shadow: 0 4px 14px rgba(124, 179, 66, 0.35); transition: background 0.2s;"
           onmouseover="this.style.background='var(--primary-dark, #3C6A00)'"
           onmouseout="this.style.background='var(--primary, #7CB342)'">
          <span>Lanjut ke Checkout ({{ $totalItems }} Item)</span>
          <svg viewBox="0 0 20 20" fill="currentColor" width="18" height="18">
            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
          </svg>
        </a>

        <div style="text-align: center; margin-top: 14px;">
          <a href="/" style="font-size: 13.5px; color: var(--primary-dark, #3C6A00); text-decoration: none; font-weight: 600;">
            ← Lanjutkan Belanja Lainnya
          </a>
        </div>
      </div>

    </div>
  @endif

@endsection
