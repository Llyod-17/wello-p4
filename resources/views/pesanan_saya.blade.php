@extends('layouts.master')

@section('judul', 'Pesanan & Aktivitas Saya - Wello Vitality Grocer')

@push('styles')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('konten_utama')
  <div style="margin-bottom: 24px;">
    <h1 style="font-size: 26px; font-weight: 800; color: var(--text, #191C1A); margin: 0 0 6px 0;">
      Aktivitas &amp; Pesanan Saya
    </h1>
    <p style="color: var(--text-muted, #424939); font-size: 15px; margin: 0;">
      Pantau riwayat transaksi, ringkasan pengeluaran, dan status pengiriman belanjaan Anda.
    </p>
  </div>

  <!-- STATS CARDS USER (INOVASI FITUR 3) -->
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); gap: 16px; margin-bottom: 28px;">
    <!-- Card 1: Total Belanja -->
    <div style="background: #FFFFFF; border: 1px solid var(--border, #C2C9B5); border-radius: 12px; padding: 18px 20px; box-shadow: 0 2px 8px rgba(27, 48, 34, 0.04);">
      <div style="font-size: 11px; font-weight: 800; color: var(--text-light, #737A68); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">
        Total Pengeluaran
      </div>
      <div style="font-size: 22px; font-weight: 800; color: #3C6A00;">
        Rp {{ number_format($userTotalSpent, 0, ',', '.') }}
      </div>
      <div style="font-size: 11px; color: var(--text-muted, #424939); margin-top: 4px;">Dari pesanan lunas/terkirim</div>
    </div>

    <!-- Card 2: Total Pesanan -->
    <div style="background: #FFFFFF; border: 1px solid var(--border, #C2C9B5); border-radius: 12px; padding: 18px 20px; box-shadow: 0 2px 8px rgba(27, 48, 34, 0.04);">
      <div style="font-size: 11px; font-weight: 800; color: var(--text-light, #737A68); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">
        Total Transaksi
      </div>
      <div style="font-size: 22px; font-weight: 800; color: var(--text, #191C1A);">
        {{ $userTotalOrders }} <span style="font-size: 13px; font-weight: 600; color: var(--text-muted, #424939);">Pesanan</span>
      </div>
      <div style="font-size: 11px; color: var(--text-muted, #424939); margin-top: 4px;">Seluruh riwayat belanja</div>
    </div>

    <!-- Card 3: Pesanan Aktif -->
    <div style="background: #FFFFFF; border: 1px solid var(--border, #C2C9B5); border-radius: 12px; padding: 18px 20px; box-shadow: 0 2px 8px rgba(27, 48, 34, 0.04);">
      <div style="font-size: 11px; font-weight: 800; color: var(--text-light, #737A68); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">
        Dalam Proses
      </div>
      <div style="font-size: 22px; font-weight: 800; color: #856404;">
        {{ $userActiveOrders }} <span style="font-size: 13px; font-weight: 600; color: var(--text-muted, #424939);">Pesanan</span>
      </div>
      <div style="font-size: 11px; color: var(--text-muted, #424939); margin-top: 4px;">Pending / Dipersiapkan</div>
    </div>

    <!-- Card 4: Pesanan Selesai -->
    <div style="background: #FFFFFF; border: 1px solid var(--border, #C2C9B5); border-radius: 12px; padding: 18px 20px; box-shadow: 0 2px 8px rgba(27, 48, 34, 0.04);">
      <div style="font-size: 11px; font-weight: 800; color: var(--text-light, #737A68); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px;">
        Pesanan Diterima
      </div>
      <div style="font-size: 22px; font-weight: 800; color: #0F5132;">
        {{ $userCompletedOrders }} <span style="font-size: 13px; font-weight: 600; color: var(--text-muted, #424939);">Pesanan</span>
      </div>
      <div style="font-size: 11px; color: var(--text-muted, #424939); margin-top: 4px;">Terkirim dengan sukses</div>
    </div>
  </div>

  @if($userTotalOrders > 0)
    <!-- GRAFIK STATISTIK BELANJA USER (INOVASI FITUR 3) -->
    <div style="margin-bottom: 32px;">
      <h2 style="font-size: 18px; font-weight: 800; color: var(--text, #191C1A); margin: 0 0 16px 0;">
        📊 Statistik Belanja Saya
      </h2>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 18px;">
        <!-- Grafik 1: Tren Belanja 6 Bulan Terakhir -->
        <div style="background: #FFFFFF; border: 1px solid var(--border, #C2C9B5); border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(27, 48, 34, 0.04);">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
            <span style="font-size: 14px; font-weight: 700; color: var(--text, #191C1A);">
              Tren Pengeluaran (6 Bulan Terakhir)
            </span>
            <span style="font-size: 11px; font-weight: 700; color: #3C6A00; background: #EAEFD9; padding: 3px 8px; border-radius: 6px;">Rupiah</span>
          </div>
          <div style="position: relative; height: 210px; width: 100%;">
            <canvas id="chartUserMonthly"></canvas>
          </div>
        </div>

        <!-- Grafik 2: Produk Favorit / Status Pesanan -->
        <div style="background: #FFFFFF; border: 1px solid var(--border, #C2C9B5); border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(27, 48, 34, 0.04);">
          <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
            <span style="font-size: 14px; font-weight: 700; color: var(--text, #191C1A);">
              Produk Favorit Terbanyak
            </span>
            <span style="font-size: 11px; font-weight: 700; color: #856404; background: #FFF3CD; padding: 3px 8px; border-radius: 6px;">Unit</span>
          </div>
          <div style="position: relative; height: 210px; width: 100%;">
            <canvas id="chartUserFav"></canvas>
          </div>
        </div>
      </div>
    </div>
  @endif

  <div style="margin-bottom: 16px;">
    <h2 style="font-size: 18px; font-weight: 800; color: var(--text, #191C1A); margin: 0;">
      📦 Daftar Riwayat Pesanan
    </h2>
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
                Total: <strong>{{ $t->quantity }} Pcs</strong> &bull; Kurir: <strong>{{ $t->courier }}</strong>
                @if($t->discount_amount > 0)
                  &bull; <span style="color: #3C6A00; font-weight: 700;">🎟️ Diskon Rp {{ number_format($t->discount_amount, 0, ',', '.') }}</span>
                @endif
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

  @if($userTotalOrders > 0)
    <!-- SCRIPT CHART USER -->
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const primaryColor = '#3C6A00';
        const primaryLight = 'rgba(60, 106, 0, 0.15)';

        // 1. Chart Monthly Spent (Line)
        const ctxMonthly = document.getElementById('chartUserMonthly')?.getContext('2d');
        if (ctxMonthly) {
          new Chart(ctxMonthly, {
            type: 'line',
            data: {
              labels: @json($chartUserMonthlyLabels),
              datasets: [{
                label: 'Pengeluaran (Rp)',
                data: @json($chartUserMonthlyValues),
                borderColor: primaryColor,
                backgroundColor: primaryLight,
                fill: true,
                tension: 0.35,
                borderWidth: 2.5,
                pointRadius: 4,
                pointBackgroundColor: primaryColor
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: { display: false },
                tooltip: {
                  callbacks: {
                    label: function(ctx) {
                      return 'Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                    }
                  }
                }
              },
              scales: {
                y: {
                  beginAtZero: true,
                  ticks: {
                    callback: function(v) {
                      if (v >= 1000) return 'Rp ' + (v/1000).toFixed(0) + 'k';
                      return 'Rp ' + v;
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

        // 2. Chart Favorite Products (Bar)
        const ctxFav = document.getElementById('chartUserFav')?.getContext('2d');
        if (ctxFav) {
          const labels = @json($chartFavLabels);
          const values = @json($chartFavValues);
          new Chart(ctxFav, {
            type: 'bar',
            data: {
              labels: labels.length ? labels : ['Belum ada pembelian'],
              datasets: [{
                label: 'Jumlah Beli',
                data: values.length ? values : [0],
                backgroundColor: ['#7CB342', '#FF8F06', '#0B5ED7', '#9C27B0', '#009688'],
                borderRadius: 6
              }]
            },
            options: {
              indexAxis: 'y',
              responsive: true,
              maintainAspectRatio: false,
              plugins: { legend: { display: false } },
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
      });
    </script>
  @endif

@endsection
