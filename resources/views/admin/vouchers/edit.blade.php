@extends('layouts.admin')

@section('judul', 'Edit Voucher ' . $voucher->code . ' - Wello Back-Office')

@section('konten_admin')

    <div style="max-width: 760px; margin: 0 auto;">
        
        <div style="margin-bottom: 24px;">
            <a href="{{ route('admin.vouchers.index') }}" 
               style="color: var(--text-muted); text-decoration: none; font-size: 13.5px; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; margin-bottom: 12px;">
                <i data-lucide="arrow-left" style="width: 16px; height: 16px;"></i>
                Kembali ke Daftar Voucher
            </a>
            <h1 style="font-size: 26px; font-weight: 800; color: var(--text-main); margin: 0 0 6px 0;">
                Edit Voucher: {{ $voucher->code }}
            </h1>
            <p style="margin: 0; font-size: 14px; color: var(--text-muted);">
                Perbarui ketentuan kupon, besaran diskon, atau kuota penggunaan.
            </p>
        </div>

        @if($errors->any())
            <div style="background-color: #FFF4F2; color: #BA1A1A; border: 1px solid #FFDAD6; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px;">
                <div style="font-weight: 700; margin-bottom: 8px;">Mohon periksa kembali input Anda:</div>
                <ul style="margin: 0; padding-left: 20px; font-size: 13.5px;">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="background: var(--surface); border-radius: 16px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-card); padding: 32px;"
             x-data="{ discountType: '{{ old('type', $voucher->type) }}' }">
            
            <form action="{{ route('admin.vouchers.update', $voucher->id) }}" method="POST">
                @csrf

                <!-- Grid Baris 1: Kode & Nama -->
                <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                            Kode Voucher <span style="color: #BA1A1A;">*</span>
                        </label>
                        <input type="text" name="code" value="{{ old('code', $voucher->code) }}" required
                               style="width: 100%; padding: 12px 14px; border-radius: 10px; border: 1.5px solid var(--border-subtle); font-family: monospace; font-size: 14px; font-weight: 700; text-transform: uppercase;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                            Nama Promo / Judul <span style="color: #BA1A1A;">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $voucher->name) }}" required
                               style="width: 100%; padding: 12px 14px; border-radius: 10px; border: 1.5px solid var(--border-subtle); font-size: 14px;">
                    </div>
                </div>

                <!-- Grid Baris 2: Tipe Diskon & Besaran -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                            Tipe Diskon <span style="color: #BA1A1A;">*</span>
                        </label>
                        <select name="type" x-model="discountType" required
                                style="width: 100%; padding: 12px 14px; border-radius: 10px; border: 1.5px solid var(--border-subtle); font-size: 14px; background: #fff;">
                            <option value="percentage">Persentase (%)</option>
                            <option value="fixed">Nominal Tetap (Rp)</option>
                        </select>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                            Besaran Potongan <span style="color: #BA1A1A;">*</span>
                        </label>
                        <input type="number" name="reward_amount" value="{{ old('reward_amount', $voucher->reward_amount) }}" required min="1"
                               style="width: 100%; padding: 12px 14px; border-radius: 10px; border: 1.5px solid var(--border-subtle); font-size: 14px; font-weight: 700;">
                    </div>
                </div>

                <!-- Grid Baris 3: Maksimal Diskon (jika %) & Minimal Belanja -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                    <div x-show="discountType === 'percentage'">
                        <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                            Maksimal Potongan (Rp) <span style="font-weight: 400; color: var(--text-light);">(Opsional)</span>
                        </label>
                        <input type="number" name="max_discount" value="{{ old('max_discount', $voucher->max_discount) }}" min="0"
                               style="width: 100%; padding: 12px 14px; border-radius: 10px; border: 1.5px solid var(--border-subtle); font-size: 14px;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                            Minimal Belanja (Rp) <span style="font-weight: 400; color: var(--text-light);">(Opsional)</span>
                        </label>
                        <input type="number" name="min_purchase" value="{{ old('min_purchase', $voucher->min_purchase) }}" min="0"
                               style="width: 100%; padding: 12px 14px; border-radius: 10px; border: 1.5px solid var(--border-subtle); font-size: 14px;">
                    </div>
                </div>

                <!-- Grid Baris 4: Kuota Penggunaan & Periode Aktif -->
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 24px;">
                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                            Kuota Kupon <span style="font-weight: 400; color: var(--text-light);">(Terpakai: {{ $voucher->used_count }})</span>
                        </label>
                        <input type="number" name="quota" value="{{ old('quota', $voucher->quota) }}" min="1"
                               style="width: 100%; padding: 12px 14px; border-radius: 10px; border: 1.5px solid var(--border-subtle); font-size: 14px;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                            Mulai Berlaku
                        </label>
                        <input type="date" name="start_date" value="{{ old('start_date', $voucher->start_date ? $voucher->start_date->format('Y-m-d') : '') }}"
                               style="width: 100%; padding: 12px 14px; border-radius: 10px; border: 1.5px solid var(--border-subtle); font-size: 14px;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13.5px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
                            Berakhir Pada
                        </label>
                        <input type="date" name="end_date" value="{{ old('end_date', $voucher->end_date ? $voucher->end_date->format('Y-m-d') : '') }}"
                               style="width: 100%; padding: 12px 14px; border-radius: 10px; border: 1.5px solid var(--border-subtle); font-size: 14px;">
                    </div>
                </div>

                <!-- Checkbox Aktif -->
                <div style="margin-bottom: 28px; padding: 16px; background: #F8FAF6; border-radius: 10px; border: 1px solid var(--border-subtle);">
                    <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 700; color: var(--text-main); cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $voucher->is_active) ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: var(--primary);">
                        <span>Voucher Aktif</span>
                    </label>
                </div>

                <!-- Tombol Submit -->
                <div style="display: flex; justify-content: flex-end; gap: 12px;">
                    <a href="{{ route('admin.vouchers.index') }}" 
                       style="padding: 12px 20px; border-radius: 10px; border: 1px solid var(--border-subtle); text-decoration: none; color: var(--text-muted); font-size: 14px; font-weight: 700;">
                        Batal
                    </a>
                    <button type="submit" 
                            style="padding: 12px 24px; border-radius: 10px; border: none; background: var(--primary); color: #fff; font-size: 14px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 8px;">
                        <i data-lucide="check" style="width: 18px; height: 18px;"></i>
                        Perbarui Voucher
                    </button>
                </div>
            </form>

        </div>

    </div>

@endsection
