@extends('layouts.admin')

@section('judul', 'Pesanan Masuk - Wello Back-Office')

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

    <!-- STATS CARDS GRID -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 32px;">

        <!-- Card 1: Total Produk -->
        <div style="background: var(--surface); padding: 24px; border-radius: 16px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-subtle); position: relative; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                <span style="font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.05em;">
                    Total Produk Etalase
                </span>
                <div style="width: 40px; height: 40px; border-radius: 10px; background: #EAEFD9; color: var(--primary); display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="shopping-bag" style="width: 20px; height: 20px;"></i>
                </div>
            </div>
            <div style="font-size: 32px; font-weight: 800; color: var(--text-main); letter-spacing: -0.02em;">
                {{ $totalProducts }} <span style="font-size: 15px; font-weight: 600; color: var(--text-muted);">Barang</span>
            </div>
        </div>

        <!-- Card 2: Total Pesanan -->
        <div style="background: var(--surface); padding: 24px; border-radius: 16px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-subtle); position: relative; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                <span style="font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.05em;">
                    Total Pesanan Masuk
                </span>
                <div style="width: 40px; height: 40px; border-radius: 10px; background: #FFF3CD; color: #856404; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="inbox" style="width: 20px; height: 20px;"></i>
                </div>
            </div>
            <div style="font-size: 32px; font-weight: 800; color: var(--text-main); letter-spacing: -0.02em;">
                {{ $totalTransactions }} <span style="font-size: 15px; font-weight: 600; color: var(--text-muted);">Transaksi</span>
            </div>
        </div>

        <!-- Card 3: Total Omzet -->
        <div style="background: var(--surface); padding: 24px; border-radius: 16px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-subtle); position: relative; overflow: hidden;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                <span style="font-size: 12px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.05em;">
                    Total Omzet Penjualan
                </span>
                <div style="width: 40px; height: 40px; border-radius: 10px; background: #D1E7DD; color: #0F5132; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="banknote" style="width: 20px; height: 20px;"></i>
                </div>
            </div>
            <div style="font-size: 28px; font-weight: 800; color: var(--primary); letter-spacing: -0.02em;">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
        </div>

    </div>

    <!-- MAIN TRANSACTIONS TABLE CARD -->
    <div style="background: var(--surface); border-radius: 16px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-card); padding: 28px;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-subtle); flex-wrap: wrap; gap: 12px;">
            <div>
                <h2 style="margin: 0 0 4px 0; font-size: 18px; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="list-orders" style="width: 20px; height: 20px; color: var(--primary);"></i>
                    Daftar Pesanan Masuk
                </h2>
                <p style="margin: 0; font-size: 13.5px; color: var(--text-muted);">
                    Diurutkan otomatis dari pesanan yang paling baru masuk (<code>latest()</code>).
                </p>
            </div>
            <div style="font-size: 13px; font-weight: 700; color: var(--primary); background: var(--primary-light); padding: 6px 14px; border-radius: 9999px; display: flex; align-items: center; gap: 6px;">
                <i data-lucide="clock" style="width: 14px; height: 14px;"></i>
                <span>{{ $transactions->count() }} Transaksi</span>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead>
                    <tr style="background-color: #F8FAF5; color: var(--text-main); text-align: left; border-bottom: 2px solid var(--border-subtle);">
                        <th style="padding: 14px 16px; font-weight: 700;">No. Invoice</th>
                        <th style="padding: 14px 16px; font-weight: 700;">Data Pembeli</th>
                        <th style="padding: 14px 16px; font-weight: 700;">Rincian Barang</th>
                        <th style="padding: 14px 16px; font-weight: 700;">Total Bayar</th>
                        <th style="padding: 14px 16px; text-align: center; font-weight: 700;">Status</th>
                        <th style="padding: 14px 16px; text-align: center; font-weight: 700;">Aksi Ubah Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $item)
                        <tr style="border-bottom: 1px solid #ECEFEA; transition: background-color 0.15s;" onmouseover="this.style.backgroundColor='#FDFEFB'" onmouseout="this.style.backgroundColor='transparent'">

                            <!-- Invoice Code & Link -->
                            <td style="padding: 16px; vertical-align: top;">
                                <div style="font-family: monospace; font-size: 14.5px; font-weight: 800; color: #0B5ED7; margin-bottom: 4px;">
                                    {{ $item->invoice_code }}
                                </div>
                                <div style="font-size: 12px; color: var(--text-light); margin-bottom: 8px;">
                                    {{ $item->created_at->format('d M Y, H:i') }} WIB
                                </div>
                                <a href="/berhasil/{{ $item->id }}" target="_blank"
                                   style="display: inline-flex; align-items: center; gap: 4px; font-size: 11.5px; color: #0B5ED7; text-decoration: none; font-weight: 700; background-color: #EFF6FF; padding: 4px 10px; border-radius: 6px; border: 1px solid #BFDBFE; transition: all 0.15s;">
                                    <span>Nota Pembeli</span>
                                    <i data-lucide="external-link" style="width: 12px; height: 12px;"></i>
                                </a>
                            </td>

                            <!-- Customer Info -->
                            <td style="padding: 16px; vertical-align: top;">
                                <div style="font-weight: 700; color: var(--text-main); font-size: 14.5px; margin-bottom: 4px;">
                                    {{ $item->customer_name }}
                                </div>
                                <div style="font-size: 12px; color: var(--primary); font-weight: 700; display: flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                                    <i data-lucide="phone" style="width: 12px; height: 12px;"></i>
                                    <span>{{ $item->customer_phone }}</span>
                                </div>
                                <div style="font-size: 12px; color: var(--text-muted); max-width: 220px; line-height: 1.4; display: flex; align-items: flex-start; gap: 4px;">
                                    <i data-lucide="map-pin" style="width: 12px; height: 12px; flex-shrink: 0; margin-top: 2px;"></i>
                                    <span>{{ $item->customer_address }}</span>
                                </div>
                            </td>

                            <!-- Product Info -->
                            <td style="padding: 16px; vertical-align: top;">
                                <div style="font-weight: 700; color: var(--text-main); margin-bottom: 4px;">
                                    {{ $item->product_name }}
                                </div>
                                <div style="font-size: 12.5px; color: var(--text-muted); margin-bottom: 4px;">
                                    Qty: <strong style="color: var(--text-main);">{{ $item->quantity }}x</strong>
                                </div>
                                <div style="font-size: 12px; color: var(--primary); font-weight: 600; display: flex; align-items: center; gap: 4px;">
                                    <i data-lucide="truck" style="width: 12px; height: 12px;"></i>
                                    <span>{{ $item->courier }} (Rp {{ number_format($item->shipping_cost, 0, ',', '.') }})</span>
                                </div>
                            </td>

                            <!-- Total Amount -->
                            <td style="padding: 16px; vertical-align: top; font-weight: 800; color: #BA1A1A; font-size: 15px; white-space: nowrap;">
                                Rp {{ number_format($item->total_amount, 0, ',', '.') }}
                            </td>

                            <!-- Status Badge -->
                            <td style="padding: 16px; vertical-align: top; text-align: center;">
                                @if($item->status == 'Pending')
                                    <span style="background-color: #FFF3CD; color: #856404; padding: 6px 12px; border-radius: 9999px; font-weight: 700; font-size: 12px; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #FFEEBA;">
                                        <i data-lucide="clock" style="width: 12px; height: 12px;"></i>
                                        Pending
                                    </span>
                                @elseif($item->status == 'Paid')
                                    <span style="background-color: #CFE2FF; color: #084298; padding: 6px 12px; border-radius: 9999px; font-weight: 700; font-size: 12px; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #B6D4FE;">
                                        <i data-lucide="credit-card" style="width: 12px; height: 12px;"></i>
                                        Paid (Lunas)
                                    </span>
                                @elseif($item->status == 'Shipped')
                                    <span style="background-color: #D1E7DD; color: #0F5132; padding: 6px 12px; border-radius: 9999px; font-weight: 700; font-size: 12px; display: inline-flex; align-items: center; gap: 4px; border: 1px solid #BADBCC;">
                                        <i data-lucide="package-check" style="width: 12px; height: 12px;"></i>
                                        Shipped
                                    </span>
                                @endif
                            </td>

                            <!-- Action Buttons -->
                            <td style="padding: 16px; vertical-align: top; text-align: center;">
                                <form action="/admin/transactions/{{ $item->id }}/status" method="POST" style="display: flex; gap: 6px; justify-content: center; flex-wrap: wrap;">
                                    @csrf

                                    <button type="submit" name="status" value="Paid"
                                            style="background-color: #0B5ED7; color: #FFFFFF; border: none; padding: 6px 10px; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer; transition: opacity 0.2s;"
                                            title="Ubah status ke Paid">
                                        Set Lunas
                                    </button>

                                    <button type="submit" name="status" value="Shipped"
                                            style="background-color: var(--primary-container); color: #FFFFFF; border: none; padding: 6px 10px; border-radius: 6px; font-size: 12px; font-weight: 700; cursor: pointer; transition: opacity 0.2s;"
                                            title="Ubah status ke Shipped">
                                        Set Dikirim
                                    </button>

                                    <button type="submit" name="status" value="Pending"
                                            style="background-color: #6C757D; color: #FFFFFF; border: none; padding: 6px 10px; border-radius: 6px; font-size: 12px; cursor: pointer; transition: opacity 0.2s;"
                                            title="Reset ke Pending">
                                        Reset
                                    </button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 48px; color: var(--text-light);">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                    <i data-lucide="package-open" style="width: 40px; height: 40px; color: var(--border-subtle);"></i>
                                    <span style="font-weight: 700; font-size: 15px; color: var(--text-main);">Belum ada pesanan masuk</span>
                                    <span style="font-size: 13px; color: var(--text-muted);">Silakan lakukan simulasi Checkout di etalase toko terlebih dahulu.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

@endsection
