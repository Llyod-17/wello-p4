@extends('layouts.admin')

@section('judul', 'Katalog Produk - Wello Back-Office')

@section('konten_admin')

    <!-- FLASH SESSION ALERT -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-300 transform opacity-0 scale-95" style="background-color: #EAEFD9; color: var(--primary); padding: 16px 20px; border-radius: 12px; border: 1px solid var(--primary-container); margin-bottom: 28px; font-weight: 700; display: flex; align-items: center; justify-content: space-between; box-shadow: var(--shadow-subtle);">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i data-lucide="check-circle-2" style="width: 20px; height: 20px; color: var(--primary);"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" style="background: none; border: none; cursor: pointer; color: var(--text-muted);">
                <i data-lucide="x" style="width: 18px; height: 18px;"></i>
            </button>
        </div>
    @endif

    <!-- HEADER ACTION AREA -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h2 style="margin: 0 0 6px 0; font-size: 22px; font-weight: 800; color: var(--text-main); letter-spacing: -0.02em;">
                Daftar Produk Toko
            </h2>
            <p style="margin: 0; font-size: 14px; color: var(--text-muted);">
                Kelola seluruh persediaan produk segar yang tayang di etalase pembeli ({{ $products->count() }} Produk).
            </p>
        </div>

        <a href="/admin/products/create"
           style="background-color: var(--primary); color: #FFFFFF; text-decoration: none; padding: 12px 20px; border-radius: 10px; font-size: 14px; font-weight: 700; display: inline-flex; align-items: center; gap: 8px; box-shadow: var(--shadow-subtle); transition: all 0.2s ease;">
            <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
            <span>Tambah Produk Baru</span>
        </a>
    </div>

    <!-- MAIN PRODUCTS TABLE CARD -->
    <div style="background: var(--surface); border-radius: 16px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-card); overflow: hidden;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead>
                    <tr style="background-color: #F8FAF5; color: var(--text-main); text-align: left; border-bottom: 2px solid var(--border-subtle);">
                        <th style="padding: 16px 20px; font-weight: 700; width: 88px;">Foto</th>
                        <th style="padding: 16px 20px; font-weight: 700;">Info Produk</th>
                        <th style="padding: 16px 20px; font-weight: 700;">Harga Satuan</th>
                        <th style="padding: 16px 20px; font-weight: 700;">Tanggal Input</th>
                        <th style="padding: 16px 20px; font-weight: 700; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr style="border-bottom: 1px solid #ECEFEA; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#FDFEFB'" onmouseout="this.style.backgroundColor='transparent'">

                            <!-- Product Thumbnail -->
                            <td style="padding: 16px 20px; vertical-align: middle;">
                                @if($product->image)
                                    <img src="{{ asset('assets/images/' . $product->image) }}" alt="{{ $product->name }}"
                                         style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px; border: 1px solid var(--border-subtle); display: block;">
                                @else
                                    <div style="width: 60px; height: 60px; background-color: #F5F7F2; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--text-light); border: 1px dashed var(--border-subtle);">
                                        <i data-lucide="image-off" style="width: 20px; height: 20px;"></i>
                                    </div>
                                @endif
                            </td>

                            <!-- Product Info -->
                            <td style="padding: 16px 20px; vertical-align: middle;">
                                <div style="font-weight: 700; color: var(--text-main); font-size: 15px; margin-bottom: 4px;">
                                    {{ $product->name }}
                                </div>
                                <div style="font-size: 13px; color: var(--text-muted); max-width: 440px; line-height: 1.5;">
                                    {{ \Illuminate\Support\Str::limit($product->description, 85) }}
                                </div>
                            </td>

                            <!-- Price -->
                            <td style="padding: 16px 20px; vertical-align: middle; font-weight: 800; color: var(--primary); font-size: 15px; white-space: nowrap;">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>

                            <!-- Date Added -->
                            <td style="padding: 16px 20px; vertical-align: middle; color: var(--text-muted); font-size: 13px; white-space: nowrap;">
                                {{ $product->created_at ? $product->created_at->format('d M Y, H:i') : '-' }} WIB
                            </td>

                            <!-- Action Link -->
                            <td style="padding: 16px 20px; vertical-align: middle; text-align: right;">
                                <a href="/detail/{{ $product->id }}" target="_blank"
                                   style="display: inline-flex; align-items: center; gap: 4px; color: #0B5ED7; text-decoration: none; font-weight: 700; font-size: 12.5px; background-color: #EFF6FF; padding: 8px 14px; border-radius: 8px; border: 1px solid #BFDBFE; transition: all 0.15s;"
                                   onmouseover="this.style.backgroundColor='#DBEAFE'" onmouseout="this.style.backgroundColor='#EFF6FF'">
                                    <span>Pratinjau</span>
                                    <i data-lucide="external-link" style="width: 12px; height: 12px;"></i>
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 48px; color: var(--text-light);">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                    <i data-lucide="package-x" style="width: 40px; height: 40px; color: var(--border-subtle);"></i>
                                    <span style="font-weight: 700; font-size: 15px; color: var(--text-main);">Belum ada produk di etalase</span>
                                    <span style="font-size: 13px; color: var(--text-muted);">Mulai tambahkan produk pertama Anda dengan tombol di atas.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
