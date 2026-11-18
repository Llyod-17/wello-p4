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

    <!-- STATS CARDS GRID (Modul 6 UPRAK) -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 32px;">

        <!-- Card 1: Total Produk -->
        <div style="background: var(--surface); padding: 20px 24px; border-radius: 16px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-subtle);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                <span style="font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.05em;">
                    Total Produk
                </span>
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #EAEFD9; color: var(--primary); display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="shopping-bag" style="width: 18px; height: 18px;"></i>
                </div>
            </div>
            <div style="font-size: 28px; font-weight: 800; color: var(--text-main); letter-spacing: -0.02em;">
                {{ $totalProducts }} <span style="font-size: 14px; font-weight: 600; color: var(--text-muted);">Item</span>
            </div>
        </div>

        <!-- Card 2: Pesanan Pending -->
        <div style="background: var(--surface); padding: 20px 24px; border-radius: 16px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-subtle);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                <span style="font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.05em;">
                    Pesanan Pending
                </span>
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #FFF3CD; color: #856404; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="clock" style="width: 18px; height: 18px;"></i>
                </div>
            </div>
            <div style="font-size: 28px; font-weight: 800; color: #856404; letter-spacing: -0.02em;">
                {{ $pendingCount }} <span style="font-size: 14px; font-weight: 600; color: var(--text-muted);">Menunggu</span>
            </div>
        </div>

        <!-- Card 3: Pesanan Sukses (Paid + Shipped) -->
        <div style="background: var(--surface); padding: 20px 24px; border-radius: 16px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-subtle);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                <span style="font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.05em;">
                    Pesanan Terverifikasi
                </span>
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #CFE2FF; color: #084298; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="check-circle" style="width: 18px; height: 18px;"></i>
                </div>
            </div>
            <div style="font-size: 28px; font-weight: 800; color: #084298; letter-spacing: -0.02em;">
                {{ $successCount }} <span style="font-size: 14px; font-weight: 600; color: var(--text-muted);">Paid / Shipped</span>
            </div>
        </div>

        <!-- Card 4: Total Omzet Bersih (Hanya Paid / Shipped) -->
        <div style="background: var(--surface); padding: 20px 24px; border-radius: 16px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-subtle);">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                <span style="font-size: 11px; font-weight: 800; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.05em;">
                    Total Omzet Bersih
                </span>
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #D1E7DD; color: #0F5132; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="banknote" style="width: 18px; height: 18px;"></i>
                </div>
            </div>
            <div style="font-size: 24px; font-weight: 800; color: var(--primary); letter-spacing: -0.02em;">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
            <div style="font-size: 11px; color: var(--text-light); margin-top: 4px;">*Eksklusi pesanan Pending</div>
        </div>

    </div>

    <!-- SECTION GRAFIK & DIAGRAM ANALITIK (INOVASI FITUR 3) -->
    <div style="margin-bottom: 32px;">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px;">
            <div>
                <h2 style="font-size: 20px; font-weight: 800; color: var(--text-main); margin: 0 0 4px 0; display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="line-chart" style="width: 22px; height: 22px; color: var(--primary);"></i>
                    Visualisasi &amp; Analitik Penjualan
                </h2>
                <p style="margin: 0; font-size: 13.5px; color: var(--text-muted);">
                    Pantau tren omzet 7 hari terakhir, produk paling diminati, dan distribusi kurir secara real-time.
                </p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 20px;">
            <!-- Grafik 1: Tren Omzet 7 Hari -->
            <div style="background: var(--surface); border-radius: 16px; border: 1px solid var(--border-subtle); padding: 22px; box-shadow: var(--shadow-subtle);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h3 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="trending-up" style="width: 17px; height: 17px; color: var(--primary);"></i>
                        Tren Omzet 7 Hari Terakhir
                    </h3>
                    <span style="font-size: 11px; font-weight: 700; color: var(--primary); background: var(--primary-light); padding: 4px 8px; border-radius: 6px;">Harian (Rp)</span>
                </div>
                <div style="position: relative; height: 240px; width: 100%;">
                    <canvas id="chartDailyRevenue"></canvas>
                </div>
            </div>

            <!-- Grafik 2: Top 5 Produk Terlaris -->
            <div style="background: var(--surface); border-radius: 16px; border: 1px solid var(--border-subtle); padding: 22px; box-shadow: var(--shadow-subtle);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h3 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="award" style="width: 17px; height: 17px; color: #FF8F06;"></i>
                        Top 5 Produk Terlaris
                    </h3>
                    <span style="font-size: 11px; font-weight: 700; color: #856404; background: #FFF3CD; padding: 4px 8px; border-radius: 6px;">Qty Terjual</span>
                </div>
                <div style="position: relative; height: 240px; width: 100%;">
                    <canvas id="chartTopProducts"></canvas>
                </div>
            </div>

            <!-- Grafik 3: Distribusi Status Pesanan -->
            <div style="background: var(--surface); border-radius: 16px; border: 1px solid var(--border-subtle); padding: 22px; box-shadow: var(--shadow-subtle);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h3 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="pie-chart" style="width: 17px; height: 17px; color: #084298;"></i>
                        Distribusi Status Pesanan
                    </h3>
                    <span style="font-size: 11px; font-weight: 700; color: #084298; background: #CFE2FF; padding: 4px 8px; border-radius: 6px;">Status</span>
                </div>
                <div style="position: relative; height: 240px; width: 100%;">
                    <canvas id="chartStatus"></canvas>
                </div>
            </div>

            <!-- Grafik 4: Preferensi Kurir Pengiriman -->
            <div style="background: var(--surface); border-radius: 16px; border: 1px solid var(--border-subtle); padding: 22px; box-shadow: var(--shadow-subtle);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h3 style="font-size: 15px; font-weight: 700; color: var(--text-main); margin: 0; display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="truck" style="width: 17px; height: 17px; color: #0F5132;"></i>
                        Preferensi Jasa Ekspedisi
                    </h3>
                    <span style="font-size: 11px; font-weight: 700; color: #0F5132; background: #D1E7DD; padding: 4px 8px; border-radius: 6px;">Total Order</span>
                </div>
                <div style="position: relative; height: 240px; width: 100%;">
                    <canvas id="chartCourier"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN TRANSACTIONS TABLE CARD -->
    <div style="background: var(--surface); border-radius: 16px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-card); padding: 28px;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid var(--border-subtle); flex-wrap: wrap; gap: 16px;">
            <div>
                <h2 style="margin: 0 0 4px 0; font-size: 18px; font-weight: 800; color: var(--text-main); display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="list-orders" style="width: 20px; height: 20px; color: var(--primary);"></i>
                    Daftar Pesanan Masuk
                </h2>
                <p style="margin: 0; font-size: 13.5px; color: var(--text-muted);">
                    Kelola status pesanan, nomor resi kurir, dan hapus pesanan fiktif.
                </p>
            </div>

            {{-- Filter Status Pesanan (Modul 6 UPRAK) --}}
            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                <span style="font-size: 13px; font-weight: 600; color: var(--text-muted);">Filter Status:</span>
                <a href="/admin/transactions" 
                   style="padding: 6px 12px; border-radius: 9999px; font-size: 12px; font-weight: 700; text-decoration: none; {{ empty($statusFilter) ? 'background: var(--primary); color: #fff;' : 'background: #F1F4ED; color: var(--text-muted);' }}">
                   Semua
                </a>
                <a href="/admin/transactions?status=Pending" 
                   style="padding: 6px 12px; border-radius: 9999px; font-size: 12px; font-weight: 700; text-decoration: none; {{ $statusFilter == 'Pending' ? 'background: #856404; color: #fff;' : 'background: #FFF3CD; color: #856404;' }}">
                   Pending
                </a>
                <a href="/admin/transactions?status=Paid" 
                   style="padding: 6px 12px; border-radius: 9999px; font-size: 12px; font-weight: 700; text-decoration: none; {{ $statusFilter == 'Paid' ? 'background: #084298; color: #fff;' : 'background: #CFE2FF; color: #084298;' }}">
                   Paid
                </a>
                <a href="/admin/transactions?status=Shipped" 
                   style="padding: 6px 12px; border-radius: 9999px; font-size: 12px; font-weight: 700; text-decoration: none; {{ $statusFilter == 'Shipped' ? 'background: #0F5132; color: #fff;' : 'background: #D1E7DD; color: #0F5132;' }}">
                   Shipped
                </a>
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
                            <td style="padding: 16px; vertical-align: top; white-space: nowrap;">
                                <div style="font-weight: 800; color: #BA1A1A; font-size: 15px;">
                                    Rp {{ number_format($item->total_amount, 0, ',', '.') }}
                                </div>
                                @if($item->discount_amount > 0)
                                    <div style="font-size: 11px; font-weight: 700; color: #0F5132; background: #D1E7DD; padding: 2px 6px; border-radius: 4px; display: inline-block; margin-top: 4px;">
                                        🎟️ {{ $item->voucher_code }}: -Rp {{ number_format($item->discount_amount, 0, ',', '.') }}
                                    </div>
                                @endif
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
                                    @if($item->tracking_number)
                                        <div style="font-size: 11px; font-family: monospace; font-weight: 700; color: #0F5132; margin-top: 4px;">
                                            Resi: {{ $item->tracking_number }}
                                        </div>
                                    @endif
                                @else
                                    <span style="background-color: #F8D7DA; color: #842029; padding: 6px 12px; border-radius: 9999px; font-weight: 700; font-size: 12px;">
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>

                            <!-- Action Buttons & Resi Modal/Form -->
                            <td style="padding: 16px; vertical-align: top; text-align: center;">
                                <div style="display: flex; flex-direction: column; gap: 8px; align-items: center;">
                                    <form action="/admin/transactions/{{ $item->id }}/status" method="POST" style="display: flex; flex-direction: column; gap: 6px; width: 100%; max-width: 180px;">
                                        @csrf
                                        <div style="display: flex; gap: 4px; justify-content: center;">
                                            <button type="submit" name="status" value="Paid"
                                                    style="flex: 1; background-color: #0B5ED7; color: #FFFFFF; border: none; padding: 5px 8px; border-radius: 6px; font-size: 11.5px; font-weight: 700; cursor: pointer;"
                                                    title="Ubah status ke Paid">
                                                Paid
                                            </button>
                                            <button type="submit" name="status" value="Pending"
                                                    style="flex: 1; background-color: #6C757D; color: #FFFFFF; border: none; padding: 5px 8px; border-radius: 6px; font-size: 11.5px; cursor: pointer;"
                                                    title="Reset ke Pending">
                                                Pending
                                            </button>
                                        </div>

                                        <!-- Form Input Resi untuk Status Shipped -->
                                        <div style="display: flex; gap: 4px; margin-top: 4px;">
                                            <input type="text" name="tracking_number" value="{{ $item->tracking_number }}" placeholder="No. Resi"
                                                   style="width: 100px; font-size: 11px; padding: 4px 6px; border: 1px solid var(--border-subtle); border-radius: 4px; outline: none;">
                                            <button type="submit" name="status" value="Shipped"
                                                    style="background-color: var(--primary); color: #FFFFFF; border: none; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; cursor: pointer; white-space: nowrap;">
                                                Kirim
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Tombol Hapus Pesanan Fiktif/Batal -->
                                    <form action="/admin/transactions/{{ $item->id }}/delete" method="POST" onsubmit="return confirm('Hapus pesanan ini secara permanen?')">
                                        @csrf
                                        <button type="submit" 
                                                style="background: transparent; color: #BA1A1A; border: 1px solid #FFDAD6; border-radius: 4px; padding: 3px 8px; font-size: 11px; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                            <i data-lucide="trash-2" style="width: 12px; height: 12px;"></i>
                                            <span>Hapus Pesanan</span>
                                        </button>
                                    </form>
                                </div>
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

    <!-- SCRIPT INITIALIZE CHART.JS UNTUK ADMIN -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Palette warna Wello Vitality Grocer
            const welloGreen = '#3C6A00';
            const welloGreenLight = 'rgba(60, 106, 0, 0.15)';
            const welloAccent = '#FF8F06';
            const welloBlue = '#0B5ED7';
            const welloYellow = '#F59E0B';
            const welloRed = '#DC2626';

            // 1. Chart Omzet Harian (Line)
            const ctxDaily = document.getElementById('chartDailyRevenue')?.getContext('2d');
            if (ctxDaily) {
                new Chart(ctxDaily, {
                    type: 'line',
                    data: {
                        labels: @json($chartDailyLabels),
                        datasets: [{
                            label: 'Omzet (Rp)',
                            data: @json($chartDailyValues),
                            borderColor: welloGreen,
                            backgroundColor: welloGreenLight,
                            fill: true,
                            tension: 0.35,
                            borderWidth: 2.5,
                            pointRadius: 4,
                            pointBackgroundColor: welloGreen,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(1) + 'M';
                                        if (value >= 1000) return 'Rp ' + (value/1000).toFixed(0) + 'k';
                                        return 'Rp ' + value;
                                    },
                                    font: { size: 11 }
                                },
                                grid: { color: 'rgba(0,0,0,0.05)' }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 11 } }
                            }
                        }
                    }
                });
            }

            // 2. Chart Top Produk (Horizontal Bar)
            const ctxTop = document.getElementById('chartTopProducts')?.getContext('2d');
            if (ctxTop) {
                const labels = @json($chartTopProductLabels);
                const values = @json($chartTopProductValues);
                new Chart(ctxTop, {
                    type: 'bar',
                    data: {
                        labels: labels.length ? labels : ['Belum ada data'],
                        datasets: [{
                            label: 'Unit Terjual',
                            data: values.length ? values : [0],
                            backgroundColor: ['#7CB342', '#FF8F06', '#29B6F6', '#AB47BC', '#26A69A'],
                            borderRadius: 6
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                ticks: { precision: 0, font: { size: 11 } },
                                grid: { color: 'rgba(0,0,0,0.05)' }
                            },
                            y: {
                                grid: { display: false },
                                ticks: { font: { size: 11, weight: '600' } }
                            }
                        }
                    }
                });
            }

            // 3. Chart Status Order (Doughnut)
            const ctxStatus = document.getElementById('chartStatus')?.getContext('2d');
            if (ctxStatus) {
                new Chart(ctxStatus, {
                    type: 'doughnut',
                    data: {
                        labels: @json($chartStatusLabels),
                        datasets: [{
                            data: @json($chartStatusValues),
                            backgroundColor: [welloYellow, welloBlue, welloGreen, welloRed],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { boxWidth: 12, font: { size: 11, weight: '600' }, padding: 12 }
                            }
                        },
                        cutout: '65%'
                    }
                });
            }

            // 4. Chart Kurir (Bar)
            const ctxCourier = document.getElementById('chartCourier')?.getContext('2d');
            if (ctxCourier) {
                const cLabels = @json($chartCourierLabels);
                const cValues = @json($chartCourierValues);
                new Chart(ctxCourier, {
                    type: 'bar',
                    data: {
                        labels: cLabels.length ? cLabels : ['Belum ada data'],
                        datasets: [{
                            label: 'Jumlah Pesanan',
                            data: cValues.length ? cValues : [0],
                            backgroundColor: '#3C6A00',
                            borderRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { precision: 0, font: { size: 11 } },
                                grid: { color: 'rgba(0,0,0,0.05)' }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { size: 11, weight: '600' } }
                            }
                        }
                    }
                });
            }
        });
    </script>

@endsection
