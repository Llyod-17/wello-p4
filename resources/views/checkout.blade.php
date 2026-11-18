@extends('layouts.master')

@section('judul', 'Checkout - ' . $product->name . ' - Wello')

@section('konten_utama')
  <!-- Breadcrumb Navigation -->
  <nav class="breadcrumb mb-md" aria-label="Breadcrumb">
    <a href="/" style="color: var(--primary-dark, #3C6A00); text-decoration: none; font-weight: 500;">Katalog</a>
    <span style="color: var(--text-light, #737A68); margin: 0 8px;">/</span>
    <a href="/detail/{{ $product->id }}" style="color: var(--primary-dark, #3C6A00); text-decoration: none; font-weight: 500;">{{ $product->name }}</a>
    <span style="color: var(--text-light, #737A68); margin: 0 8px;">/</span>
    <span style="color: var(--text-muted, #424939); font-weight: 600;">Checkout</span>
  </nav>

  <div style="margin-bottom: 24px;">
    <h1 style="font-size: 28px; font-weight: 700; color: var(--text, #191C1A); margin: 0 0 6px 0; letter-spacing: -0.02em;">
      Formulir Pengiriman & Pembayaran
    </h1>
    <p style="color: var(--text-muted, #424939); font-size: 15px; margin: 0;">
      Lengkapi alamat pengiriman untuk mengantar produk segar langsung ke rumahmu.
    </p>
  </div>

  <div style="display: flex; gap: 28px; align-items: flex-start; flex-wrap: wrap;">

    <!-- KOLOM KIRI: FORMULIR INPUT PEMBELI -->
    <div style="flex: 1 1 560px; background: #FFFFFF; border: 1px solid var(--border, #C2C9B5); border-radius: 16px; padding: 32px; box-shadow: 0 4px 20px rgba(27, 48, 34, 0.05);">
      
      @if ($errors->any())
        <div style="background: #FFEDEC; border: 1px solid #FFDAD6; color: #BA1A1A; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;">
          <ul style="margin: 0; padding-left: 20px;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="/checkout/proses" method="POST" id="checkout-form">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-weight: 600; font-size: 14px; color: var(--text, #191C1A); margin-bottom: 8px;">
            Nama Lengkap Penerima <span style="color: #BA1A1A;">*</span>
          </label>
          <input type="text" name="customer_name" value="{{ old('customer_name', Auth::user()->name ?? '') }}" placeholder="Contoh: Budi Santoso"
                 style="width: 100%; padding: 12px 14px; border: 1.5px solid var(--border, #C2C9B5); border-radius: 8px; font-family: inherit; font-size: 15px; box-sizing: border-box; outline: none; transition: border-color 0.2s;"
                 onfocus="this.style.borderColor='var(--primary, #7CB342)'" onblur="this.style.borderColor='var(--border, #C2C9B5)'"
                 required>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-weight: 600; font-size: 14px; color: var(--text, #191C1A); margin-bottom: 8px;">
            Nomor WhatsApp / HP Aktif <span style="color: #BA1A1A;">*</span>
          </label>
          <input type="tel" name="customer_phone" value="{{ old('customer_phone', Auth::user()->phone ?? '') }}" placeholder="Contoh: 081234567890"
                 style="width: 100%; padding: 12px 14px; border: 1.5px solid var(--border, #C2C9B5); border-radius: 8px; font-family: inherit; font-size: 15px; box-sizing: border-box; outline: none; transition: border-color 0.2s;"
                 onfocus="this.style.borderColor='var(--primary, #7CB342)'" onblur="this.style.borderColor='var(--border, #C2C9B5)'"
                 required>
        </div>

        <div style="margin-bottom: 20px;">
          <label style="display: block; font-weight: 600; font-size: 14px; color: var(--text, #191C1A); margin-bottom: 8px;">
            Alamat Lengkap Pengiriman <span style="color: #BA1A1A;">*</span>
          </label>
          <textarea name="customer_address" rows="3" placeholder="Tuliskan nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan, dan kota/kabupaten..."
                    style="width: 100%; padding: 12px 14px; border: 1.5px solid var(--border, #C2C9B5); border-radius: 8px; font-family: inherit; font-size: 15px; box-sizing: border-box; outline: none; resize: vertical; transition: border-color 0.2s;"
                    onfocus="this.style.borderColor='var(--primary, #7CB342)'" onblur="this.style.borderColor='var(--border, #C2C9B5)'"
                    required>{{ old('customer_address') }}</textarea>
        </div>

        <div style="display: flex; gap: 16px; margin-bottom: 24px; flex-wrap: wrap;">
          <div style="flex: 2 1 240px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: var(--text, #191C1A); margin-bottom: 8px;">
              Pilih Ekspedisi Kurir <span style="color: #BA1A1A;">*</span>
            </label>
            <select name="courier" id="courier-select"
                    style="width: 100%; padding: 12px 14px; border: 1.5px solid var(--border, #C2C9B5); border-radius: 8px; font-family: inherit; font-size: 15px; background: #FFFFFF; box-sizing: border-box; outline: none; cursor: pointer;"
                    required>
              <option value="JNE Reguler" data-ongkir="15000" {{ old('courier') == 'JNE Reguler' ? 'selected' : '' }}>JNE Reguler (Ongkir Rp 15.000)</option>
              <option value="J&T Express" data-ongkir="20000" {{ old('courier') == 'J&T Express' ? 'selected' : '' }}>J&T Express (Ongkir Rp 20.000)</option>
              <option value="SiCepat BEST" data-ongkir="25000" {{ old('courier') == 'SiCepat BEST' ? 'selected' : '' }}>SiCepat BEST (Ongkir Rp 25.000)</option>
            </select>
          </div>

          <div style="flex: 1 1 120px;">
            <label style="display: block; font-weight: 600; font-size: 14px; color: var(--text, #191C1A); margin-bottom: 8px;">
              Jumlah Beli (Max: {{ $product->stock }}) <span style="color: #BA1A1A;">*</span>
            </label>
            <input type="number" name="quantity" id="quantity-input" value="{{ old('quantity', 1) }}" min="1" max="{{ $product->stock }}"
                   style="width: 100%; padding: 12px 14px; border: 1.5px solid var(--border, #C2C9B5); border-radius: 8px; font-family: inherit; font-size: 15px; box-sizing: border-box; outline: none;"
                   required>
          </div>
        </div>

        <!-- INOVASI FITUR 1: VOUCHER DISKON INPUT -->
        <div style="background: #F8FAF6; border: 1.5px dashed var(--primary, #7CB342); border-radius: 12px; padding: 18px 20px; margin-bottom: 24px;">
          <label style="display: block; font-weight: 700; font-size: 14px; color: var(--text, #191C1A); margin-bottom: 8px;">
            🎟️ Punya Kode Voucher Diskon?
          </label>
          <div style="display: flex; gap: 10px;">
            <input type="text" id="voucher-input" placeholder="Masukkan kode voucher..."
                   style="flex: 1; padding: 11px 14px; border: 1.5px solid var(--border, #C2C9B5); border-radius: 8px; font-family: monospace; font-size: 14px; font-weight: 700; text-transform: uppercase;">
            <button type="button" id="btn-apply-voucher"
                    style="padding: 11px 20px; background: var(--primary, #7CB342); color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; white-space: nowrap;">
              Terapkan
            </button>
            <button type="button" id="btn-remove-voucher" style="display: none; padding: 11px 16px; background: #FFF4F2; color: #BA1A1A; border: 1px solid #FFDAD6; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer;">
              Batal
            </button>
          </div>
          <div id="voucher-feedback" style="margin-top: 8px; font-size: 13px; display: none;"></div>
          <!-- Hidden input yang dikirim ke backend -->
          <input type="hidden" name="voucher_code" id="hidden-voucher-code" value="">
        </div>

        <button type="submit"
                style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; background: var(--primary, #7CB342); color: #FFFFFF; padding: 14px 24px; font-size: 16px; font-weight: 700; border: none; border-radius: 10px; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 4px 14px rgba(124, 179, 66, 0.35);"
                onmouseover="this.style.background='var(--primary-dark, #3C6A00)'; this.style.transform='translateY(-1px)';"
                onmouseout="this.style.background='var(--primary, #7CB342)'; this.style.transform='translateY(0)';"
                onmousedown="this.style.transform='scale(0.99)';">
          <span>Konfirmasi & Buat Pesanan Sekarang</span>
          <svg viewBox="0 0 20 20" fill="currentColor" width="18" height="18" aria-hidden="true">
            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
          </svg>
        </button>
      </form>

    </div>

    <!-- KOLOM KANAN: RINGKASAN PRODUK PESANAN -->
    <div style="flex: 1 1 340px; background: #FFFFFF; border: 1px solid var(--border, #C2C9B5); border-radius: 16px; padding: 28px; box-shadow: 0 4px 20px rgba(27, 48, 34, 0.05); position: sticky; top: 90px;">
      <h3 style="margin: 0 0 16px 0; font-size: 18px; font-weight: 700; color: var(--text, #191C1A); border-bottom: 1.5px solid #F2F4EF; padding-bottom: 12px;">
        Ringkasan Pesanan
      </h3>

      <div style="display: flex; gap: 16px; margin-bottom: 20px; align-items: center;">
        <div style="width: 88px; height: 88px; flex-shrink: 0; background: #F5F7F2; border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border, #C2C9B5);">
          @if($product->image)
            <img src="{{ asset('assets/images/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
          @else
            <span style="font-size: 28px;">📦</span>
          @endif
        </div>
        <div>
          <span style="display: inline-block; background: #EAEFD9; color: var(--primary-dark, #3C6A00); font-size: 11px; font-weight: 700; text-transform: uppercase; padding: 2px 8px; border-radius: 9999px; margin-bottom: 4px;">
            Produk Segar
          </span>
          <h4 style="margin: 0 0 4px 0; font-size: 16px; font-weight: 700; color: var(--text, #191C1A);">
            {{ $product->name }}
          </h4>
          <p style="margin: 0; font-size: 13px; color: var(--text-muted, #424939);">
            Harga Satuan:
          </p>
          <p style="margin: 0; font-size: 18px; font-weight: 800; color: var(--primary-dark, #3C6A00);">
            Rp {{ number_format($product->price, 0, ',', '.') }}
          </p>
        </div>
      </div>

      <div style="background: #F8FAF5; border-radius: 12px; padding: 16px; margin-bottom: 20px; border: 1px dashed var(--border, #C2C9B5);">
        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; color: var(--text-muted, #424939);">
          <span>Subtotal Produk (<span id="calc-qty">1</span>x)</span>
          <span style="font-weight: 600;" id="calc-subtotal">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px; color: var(--text-muted, #424939);">
          <span>Estimasi Ongkir</span>
          <span style="font-weight: 600;" id="calc-ongkir">Rp 15.000</span>
        </div>

        <!-- Baris Diskon Voucher -->
        <div id="row-voucher-discount" style="display: none; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: #3C6A00; background: #EAEFD9; padding: 6px 10px; border-radius: 6px; font-weight: 700;">
          <span id="label-voucher">🎟️ Diskon Voucher</span>
          <span id="calc-diskon">- Rp 0</span>
        </div>

        <hr style="border: 0; border-top: 1px solid var(--border, #C2C9B5); margin: 8px 0 12px 0;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <span style="font-size: 14px; font-weight: 700; color: var(--text, #191C1A);">Estimasi Total</span>
          <span style="font-size: 20px; font-weight: 800; color: #BA1A1A;" id="calc-total">
            Rp {{ number_format($product->price + 15000, 0, ',', '.') }}
          </span>
        </div>
      </div>

      <div style="display: flex; gap: 10px; align-items: flex-start; font-size: 12px; color: var(--text-light, #737A68); line-height: 1.5;">
        <svg viewBox="0 0 20 20" fill="currentColor" width="16" height="16" style="flex-shrink: 0; color: var(--primary, #7CB342); margin-top: 2px;">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <span>
          Total tagihan resmi akan direkam permanen ke database setelah Anda menekan tombol Konfirmasi.
        </span>
      </div>
    </div>

  </div>

  {{-- Script interaktif kalkulasi real-time & voucher ajax di sisi client --}}
  <script>
    (function() {
      const price = {{ (int) $product->price }};
      const qtyInput = document.getElementById('quantity-input');
      const courierSelect = document.getElementById('courier-select');
      const calcQty = document.getElementById('calc-qty');
      const calcSubtotal = document.getElementById('calc-subtotal');
      const calcOngkir = document.getElementById('calc-ongkir');
      const calcTotal = document.getElementById('calc-total');

      // Voucher elements
      const voucherInput = document.getElementById('voucher-input');
      const btnApplyVoucher = document.getElementById('btn-apply-voucher');
      const btnRemoveVoucher = document.getElementById('btn-remove-voucher');
      const voucherFeedback = document.getElementById('voucher-feedback');
      const hiddenVoucherCode = document.getElementById('hidden-voucher-code');
      const rowVoucherDiscount = document.getElementById('row-voucher-discount');
      const labelVoucher = document.getElementById('label-voucher');
      const calcDiskon = document.getElementById('calc-diskon');

      let currentDiscount = 0;
      let appliedVoucherCode = '';

      function formatRupiah(num) {
        return 'Rp ' + Math.max(0, num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
      }

      function updateCalculation() {
        const qty = Math.max(1, parseInt(qtyInput.value) || 1);
        const selectedOption = courierSelect.options[courierSelect.selectedIndex];
        const ongkir = parseInt(selectedOption.getAttribute('data-ongkir')) || 15000;
        const subtotal = price * qty;
        const total = Math.max(0, subtotal + ongkir - currentDiscount);

        if (calcQty) calcQty.textContent = qty;
        if (calcSubtotal) calcSubtotal.textContent = formatRupiah(subtotal);
        if (calcOngkir) calcOngkir.textContent = formatRupiah(ongkir);
        if (calcTotal) calcTotal.textContent = formatRupiah(total);
      }

      if (qtyInput) qtyInput.addEventListener('input', function() {
        // Jika qty berubah dan voucher sedang aktif, verifikasi ulang
        if (appliedVoucherCode) {
          revalidateVoucher();
        } else {
          updateCalculation();
        }
      });

      if (courierSelect) courierSelect.addEventListener('change', updateCalculation);

      // Handle Apply Voucher via AJAX
      function applyVoucher() {
        const code = (voucherInput.value || '').trim();
        if (!code) {
          showFeedback('Silakan ketikkan kode voucher.', false);
          return;
        }

        const qty = Math.max(1, parseInt(qtyInput.value) || 1);
        const subtotal = price * qty;

        btnApplyVoucher.disabled = true;
        btnApplyVoucher.textContent = 'Mengecek...';

        fetch('/voucher/apply', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ code: code, subtotal: subtotal })
        })
        .then(res => res.json().then(data => ({ status: res.status, body: data })))
        .then(result => {
          btnApplyVoucher.disabled = false;
          btnApplyVoucher.textContent = 'Terapkan';

          if (result.status === 200 && result.body.success) {
            currentDiscount = result.body.discount_amount;
            appliedVoucherCode = result.body.voucher_code;
            hiddenVoucherCode.value = appliedVoucherCode;

            voucherInput.readOnly = true;
            btnApplyVoucher.style.display = 'none';
            btnRemoveVoucher.style.display = 'inline-block';

            rowVoucherDiscount.style.display = 'flex';
            labelVoucher.textContent = '🎟️ Diskon (' + appliedVoucherCode + ')';
            calcDiskon.textContent = '- ' + result.body.discount_formatted;

            showFeedback(result.body.message, true);
            updateCalculation();
          } else {
            showFeedback(result.body.message || 'Voucher tidak dapat digunakan.', false);
          }
        })
        .catch(err => {
          btnApplyVoucher.disabled = false;
          btnApplyVoucher.textContent = 'Terapkan';
          showFeedback('Terjadi kendala saat memeriksa voucher. Coba lagi.', false);
        });
      }

      function revalidateVoucher() {
        if (!appliedVoucherCode) return;
        const qty = Math.max(1, parseInt(qtyInput.value) || 1);
        const subtotal = price * qty;

        fetch('/voucher/apply', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({ code: appliedVoucherCode, subtotal: subtotal })
        })
        .then(res => res.json().then(data => ({ status: res.status, body: data })))
        .then(result => {
          if (result.status === 200 && result.body.success) {
            currentDiscount = result.body.discount_amount;
            calcDiskon.textContent = '- ' + result.body.discount_formatted;
            updateCalculation();
          } else {
            removeVoucher();
            showFeedback('Voucher dibatalkan karena syarat minimal belanja tidak terpenuhi.', false);
          }
        });
      }

      function removeVoucher() {
        currentDiscount = 0;
        appliedVoucherCode = '';
        hiddenVoucherCode.value = '';
        voucherInput.value = '';
        voucherInput.readOnly = false;
        btnApplyVoucher.style.display = 'inline-block';
        btnRemoveVoucher.style.display = 'none';
        rowVoucherDiscount.style.display = 'none';
        voucherFeedback.style.display = 'none';
        updateCalculation();
      }

      function showFeedback(msg, isSuccess) {
        voucherFeedback.style.display = 'block';
        voucherFeedback.style.color = isSuccess ? '#0F5132' : '#BA1A1A';
        voucherFeedback.style.fontWeight = '600';
        voucherFeedback.textContent = (isSuccess ? '✓ ' : '✕ ') + msg;
      }

      if (btnApplyVoucher) btnApplyVoucher.addEventListener('click', applyVoucher);
      if (btnRemoveVoucher) btnRemoveVoucher.addEventListener('click', removeVoucher);
      if (voucherInput) {
        voucherInput.addEventListener('keypress', function(e) {
          if (e.key === 'Enter') {
            e.preventDefault();
            applyVoucher();
          }
        });
      }
    })();
  </script>
@endsection
