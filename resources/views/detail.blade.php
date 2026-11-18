@extends('layouts.master')

@section('judul', $product->name . ' - Detail Produk Wello')

@section('konten_utama')
<div class="product-detail-container" style="max-width: 1040px; margin: 0 auto; padding-bottom: 40px;">
    <!-- Breadcrumb Modern -->
    <nav aria-label="Breadcrumb" style="display: flex; align-items: center; gap: 8px; font-size: 13.5px; color: var(--text-light, #737A68); margin-bottom: 24px;">
        <a href="/" style="color: var(--primary-dark, #3C6A00); text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 4px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
            Katalog
        </a>
        <span>/</span>
        <span style="color: var(--text-muted, #424939); font-weight: 500;">{{ $product->category ?? 'Produk Segar' }}</span>
        <span>/</span>
        <span style="color: var(--text, #191C1A); font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 240px;">{{ $product->name }}</span>
    </nav>

    <!-- Flash Notifications -->
    @if(session('success'))
        <div style="background-color: #EAEFD9; color: var(--primary-dark, #3C6A00); padding: 14px 18px; border-radius: 12px; border: 1px solid #C2C9B5; margin-bottom: 20px; font-weight: 700; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 6px rgba(27,48,34,0.04);">
            <div style="display: flex; align-items: center; gap: 8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
            <a href="{{ route('cart.index') }}" style="color: var(--primary-dark, #3C6A00); font-size: 13px; text-decoration: underline; font-weight: 700;">Ke Keranjang →</a>
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #FFF4F2; color: #BA1A1A; padding: 14px 18px; border-radius: 12px; border: 1px solid #FFDAD6; margin-bottom: 20px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Card Wrapper Detail Produk -->
    <div style="background: #FFFFFF; border-radius: 20px; border: 1px solid var(--border, #C2C9B5); box-shadow: 0 8px 30px rgba(27, 48, 34, 0.06); padding: 32px; display: grid; grid-template-columns: minmax(280px, 420px) 1fr; gap: 40px; align-items: start;">
        
        <!-- BAGIAN KIRI: Foto & Badge Garansi -->
        <div>
            <div style="position: relative; width: 100%; aspect-ratio: 1 / 1; border-radius: 16px; overflow: hidden; background-color: #F8FAF5; border: 1px solid var(--border-subtle, #ECEFEA); box-shadow: inset 0 2px 6px rgba(0,0,0,0.02);">
                @if($product->image)
                    <img src="{{ asset('assets/images/' . $product->image) }}" alt="{{ $product->name }}"
                         style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;"
                         onmouseover="this.style.transform='scale(1.03)'"
                         onmouseout="this.style.transform='scale(1)'">
                @else
                    <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--text-light, #737A68);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
                        <span style="font-size: 13px; font-weight: 600; margin-top: 8px;">Foto Belum Tersedia</span>
                    </div>
                @endif

                <!-- Floating Category Tag -->
                <div style="position: absolute; top: 14px; left: 14px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(8px); padding: 6px 12px; border-radius: 9999px; font-size: 12px; font-weight: 700; color: #3C6A00; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; align-items: center; gap: 5px;">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #7CB342;"></span>
                    {{ $product->category ?? 'Umum' }}
                </div>
            </div>

            <!-- Value Props Mini Bar -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 18px;">
                <div style="padding: 12px; border-radius: 12px; background: #F8FAF5; border: 1px solid #ECEFEA; display: flex; align-items: center; gap: 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#3C6A00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10"></path></svg>
                    <div>
                        <div style="font-size: 12px; font-weight: 700; color: var(--text, #191C1A);">100% Segar</div>
                        <div style="font-size: 11px; color: var(--text-light, #737A68);">Garansi ganti baru</div>
                    </div>
                </div>
                <div style="padding: 12px; border-radius: 12px; background: #F8FAF5; border: 1px solid #ECEFEA; display: flex; align-items: center; gap: 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FB8C00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"></path><path d="M15 18H9"></path><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"></path><circle cx="17" cy="18" r="2"></circle><circle cx="7" cy="18" r="2"></circle></svg>
                    <div>
                        <div style="font-size: 12px; font-weight: 700; color: var(--text, #191C1A);">Kirim Cepat</div>
                        <div style="font-size: 11px; color: var(--text-light, #737A68);">Pengiriman hari ini</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- BAGIAN KANAN: Informasi, Harga & Checkout Control -->
        <div x-data="{ qty: 1, maxStock: {{ $product->stock }} }">
            <!-- Header Nama & Status Stok -->
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 8px;">
                <span style="font-size: 12.5px; font-weight: 700; color: var(--text-light, #737A68); text-transform: uppercase; letter-spacing: 0.05em;">
                    Wello Original Store
                </span>
                
                @if($product->stock <= 0)
                    <span style="display: inline-flex; align-items: center; gap: 5px; font-size: 12.5px; font-weight: 800; color: #BA1A1A; background: #FFF4F2; padding: 4px 10px; border-radius: 9999px; border: 1px solid #FFDAD6;">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #BA1A1A;"></span>
                        Stok Habis
                    </span>
                @elseif($product->stock <= 5)
                    <span style="display: inline-flex; align-items: center; gap: 5px; font-size: 12.5px; font-weight: 800; color: #E65100; background: #FFF3E0; padding: 4px 10px; border-radius: 9999px; border: 1px solid #FFE0B2;">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #E65100;"></span>
                        Sisa {{ $product->stock }} Unit (Menipis)
                    </span>
                @else
                    <span style="display: inline-flex; align-items: center; gap: 5px; font-size: 12.5px; font-weight: 800; color: #2E7D32; background: #E8F5E9; padding: 4px 10px; border-radius: 9999px; border: 1px solid #C8E6C9;">
                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #2E7D32;"></span>
                        Stok Tersedia ({{ $product->stock }})
                    </span>
                @endif
            </div>

            <h1 style="font-size: 30px; font-weight: 800; color: var(--text, #191C1A); line-height: 1.25; margin: 0 0 16px 0; letter-spacing: -0.02em;">
                {{ $product->name }}
            </h1>

            <!-- Harga Box -->
            <div style="background: #F8FAF5; border-radius: 14px; padding: 18px 22px; border: 1px solid #ECEFEA; margin-bottom: 24px; display: flex; align-items: baseline; gap: 8px;">
                <span style="font-size: 16px; font-weight: 700; color: var(--text-light, #737A68);">Rp</span>
                <span style="font-size: 32px; font-weight: 800; color: #3C6A00; letter-spacing: -0.02em;">
                    {{ number_format($product->price, 0, ',', '.') }}
                </span>
                <span style="font-size: 13.5px; color: var(--text-light, #737A68); font-weight: 500;">/ paket</span>
            </div>

            <!-- Deskripsi Produk -->
            <div style="margin-bottom: 28px;">
                <h3 style="font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted, #424939); margin: 0 0 8px 0;">
                    Deskripsi &amp; Informasi Produk
                </h3>
                <div style="line-height: 1.7; color: var(--text-muted, #424939); font-size: 14.5px; text-align: justify; background: #FAFAFA; padding: 16px 20px; border-radius: 12px; border: 1px solid #F0F0F0;">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            <!-- Action Area: Stepper Quantity & Buttons -->
            @if($product->stock > 0)
                <div style="background: #FFFFFF; border: 1.5px solid var(--border-subtle, #ECEFEA); border-radius: 16px; padding: 20px; box-shadow: 0 4px 16px rgba(27,48,34,0.03);">
                    
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; flex-wrap: wrap; gap: 12px;">
                        <span style="font-size: 14px; font-weight: 700; color: var(--text, #191C1A);">
                            Atur Jumlah Pembelian:
                        </span>

                        <!-- Interactive Alpine.js Stepper -->
                        <div style="display: inline-flex; align-items: center; border: 1.5px solid var(--border, #C2C9B5); border-radius: 10px; overflow: hidden; background: #FFF;">
                            <button type="button" @click="if(qty > 1) qty--"
                                    style="width: 38px; height: 38px; background: #F8FAF5; border: none; font-size: 18px; font-weight: 700; cursor: pointer; color: var(--text, #191C1A); display: flex; align-items: center; justify-content: center; transition: background 0.15s;"
                                    onmouseover="this.style.background='#ECEFEA'"
                                    onmouseout="this.style.background='#F8FAF5'">
                                -
                            </button>
                            <input type="number" x-model.number="qty" min="1" :max="maxStock" readonly
                                   style="width: 54px; height: 38px; border: none; text-align: center; font-weight: 800; font-size: 15px; color: var(--text, #191C1A); outline: none; background: #FFF;">
                            <button type="button" @click="if(qty < maxStock) qty++"
                                    style="width: 38px; height: 38px; background: #F8FAF5; border: none; font-size: 18px; font-weight: 700; cursor: pointer; color: var(--text, #191C1A); display: flex; align-items: center; justify-content: center; transition: background 0.15s;"
                                    onmouseover="this.style.background='#ECEFEA'"
                                    onmouseout="this.style.background='#F8FAF5'">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- Subtotal Kalkulasi Live -->
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 12px; border-top: 1px dashed var(--border-subtle, #ECEFEA); margin-bottom: 20px;">
                        <span style="font-size: 13.5px; color: var(--text-light, #737A68);">Subtotal Estimasi:</span>
                        <span style="font-size: 18px; font-weight: 800; color: #3C6A00;">
                            Rp <span x-text="(qty * {{ $product->price }}).toLocaleString('id-ID')"></span>
                        </span>
                    </div>

                    <!-- Button Duo (Tambah Keranjang & Beli Sekarang) -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        
                        <!-- Form Tambah ke Keranjang -->
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" :value="qty">
                            <button type="submit"
                                    style="width: 100%; height: 48px; background: #FFFFFF; color: #3C6A00; border: 2px solid #7CB342; border-radius: 10px; font-weight: 700; font-size: 14.5px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s ease; box-shadow: 0 2px 6px rgba(124, 179, 66, 0.15);"
                                    onmouseover="this.style.background='#F4F9EC'; this.style.transform='translateY(-1px)';"
                                    onmouseout="this.style.background='#FFFFFF'; this.style.transform='translateY(0)';"
                                    onmousedown="this.style.transform='scale(0.98)';">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                <span>+ Keranjang</span>
                            </button>
                        </form>

                        <!-- Tombol Beli Langsung -->
                        <a :href="'/checkout/{{ $product->id }}?qty=' + qty"
                           style="width: 100%; height: 48px; background: #7CB342; color: #FFFFFF; border: none; border-radius: 10px; font-weight: 700; font-size: 14.5px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: 0 4px 14px rgba(124, 179, 66, 0.35); transition: all 0.2s ease;"
                           onmouseover="this.style.background='#689F38'; this.style.transform='translateY(-1px)';"
                           onmouseout="this.style.background='#7CB342'; this.style.transform='translateY(0)';"
                           onmousedown="this.style.transform='scale(0.98)';">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                            <span>Beli Sekarang</span>
                        </a>

                    </div>
                </div>
            @else
                <div style="background: #F8FAF5; border: 1.5px dashed var(--border, #C2C9B5); border-radius: 16px; padding: 24px; text-align: center;">
                    <div style="font-size: 28px; margin-bottom: 6px;">📦</div>
                    <div style="font-weight: 800; font-size: 16px; color: var(--text, #191C1A); margin-bottom: 4px;">Produk Saat Ini Sedang Habis</div>
                    <p style="font-size: 13px; color: var(--text-muted, #424939); margin: 0 0 16px 0;">Stok sedang diisi ulang oleh petani mitra kami. Silakan cek kembali nanti.</p>
                    <a href="/" style="display: inline-block; padding: 10px 20px; background: #FFFFFF; border: 1.5px solid var(--border, #C2C9B5); border-radius: 8px; font-size: 13.5px; font-weight: 700; color: var(--text, #191C1A); text-decoration: none;">
                        Cari Produk Segar Lainnya
                    </a>
                </div>
            @endif

        </div>

    </div>
</div>
@endsection
