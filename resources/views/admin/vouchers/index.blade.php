@extends('layouts.admin')

@section('judul', 'Kelola Voucher Diskon - Wello Back-Office')

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

    <!-- HEADER & ACTION -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 26px; font-weight: 800; color: var(--text-main); margin: 0 0 6px 0; display: flex; align-items: center; gap: 10px;">
                <i data-lucide="ticket-percent" style="width: 28px; height: 28px; color: var(--primary);"></i>
                Manajemen Voucher Diskon
            </h1>
            <p style="margin: 0; font-size: 14px; color: var(--text-muted);">
                Atur kode kupon, besaran potongan harga (% atau Rupiah), minimal belanja, serta kuota pemakaian.
            </p>
        </div>

        <a href="{{ route('admin.vouchers.create') }}" 
           style="background-color: var(--primary); color: #FFFFFF; font-weight: 700; font-size: 14px; padding: 12px 22px; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(60, 106, 0, 0.25);">
            <i data-lucide="plus-circle" style="width: 18px; height: 18px;"></i>
            <span>Buat Voucher Baru</span>
        </a>
    </div>

    <!-- VOUCHERS TABLE CARD -->
    <div style="background: var(--surface); border-radius: 16px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-card); padding: 28px;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--border-subtle); text-align: left; color: var(--text-light); font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;">
                        <th style="padding: 14px 16px;">Kode &amp; Nama</th>
                        <th style="padding: 14px 16px;">Potongan Diskon</th>
                        <th style="padding: 14px 16px;">Syarat Belanja</th>
                        <th style="padding: 14px 16px; text-align: center;">Kuota &amp; Terpakai</th>
                        <th style="padding: 14px 16px;">Masa Berlaku</th>
                        <th style="padding: 14px 16px; text-align: center;">Status</th>
                        <th style="padding: 14px 16px; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vouchers as $v)
                        <tr style="border-bottom: 1px solid var(--border-subtle); transition: background-color 0.15s ease;">
                            <!-- Kode & Nama -->
                            <td style="padding: 16px; vertical-align: middle;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                    <span style="font-family: monospace; font-weight: 800; font-size: 15px; color: var(--primary); background: var(--primary-light); padding: 4px 10px; border-radius: 6px; border: 1px dashed var(--primary-container);">
                                        {{ $v->code }}
                                    </span>
                                </div>
                                <div style="font-weight: 700; color: var(--text-main); font-size: 14px;">
                                    {{ $v->name }}
                                </div>
                            </td>

                            <!-- Nilai Diskon -->
                            <td style="padding: 16px; vertical-align: middle;">
                                @if($v->type === 'percentage')
                                    <div style="font-weight: 800; color: #BA1A1A; font-size: 15px;">
                                        {{ $v->reward_amount }}% OFF
                                    </div>
                                    @if($v->max_discount)
                                        <div style="font-size: 12px; color: var(--text-muted);">
                                            Maks. Rp {{ number_format($v->max_discount, 0, ',', '.') }}
                                        </div>
                                    @endif
                                @else
                                    <div style="font-weight: 800; color: #BA1A1A; font-size: 15px;">
                                        Rp {{ number_format($v->reward_amount, 0, ',', '.') }}
                                    </div>
                                    <div style="font-size: 11px; color: var(--text-light);">Potongan Langsung</div>
                                @endif
                            </td>

                            <!-- Syarat Belanja -->
                            <td style="padding: 16px; vertical-align: middle;">
                                @if($v->min_purchase > 0)
                                    <div style="font-weight: 600; color: var(--text-main);">
                                        Min. Rp {{ number_format($v->min_purchase, 0, ',', '.') }}
                                    </div>
                                @else
                                    <span style="color: var(--text-muted); font-size: 13px;">Tanpa Minimal</span>
                                @endif
                            </td>

                            <!-- Kuota & Terpakai -->
                            <td style="padding: 16px; vertical-align: middle; text-align: center;">
                                <div style="font-weight: 700; color: var(--text-main);">
                                    {{ $v->used_count }} <span style="color: var(--text-muted); font-weight: 400;">/ {{ $v->quota ?? '∞' }}</span>
                                </div>
                                <div style="font-size: 11px; color: var(--text-light);">transaksi</div>
                            </td>

                            <!-- Masa Berlaku -->
                            <td style="padding: 16px; vertical-align: middle; font-size: 13px;">
                                @if($v->start_date && $v->end_date)
                                    <div style="color: var(--text-main); font-weight: 600;">
                                        {{ $v->start_date->format('d/m/Y') }} - {{ $v->end_date->format('d/m/Y') }}
                                    </div>
                                @elseif($v->end_date)
                                    <div style="color: var(--text-main);">
                                        s/d {{ $v->end_date->format('d/m/Y') }}
                                    </div>
                                @else
                                    <span style="color: #0F5132; font-weight: 600;">Selalu Aktif</span>
                                @endif
                            </td>

                            <!-- Status Toggle -->
                            <td style="padding: 16px; vertical-align: middle; text-align: center;">
                                <form method="POST" action="{{ route('admin.vouchers.toggle', $v->id) }}">
                                    @csrf
                                    <button type="submit" 
                                            style="border: none; background: none; cursor: pointer; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 700; {{ $v->is_active ? 'background-color: #D1E7DD; color: #0F5132;' : 'background-color: #F8D7DA; color: #842029;' }}">
                                        {{ $v->is_active ? '● Aktif' : '○ Non-Aktif' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Aksi -->
                            <td style="padding: 16px; vertical-align: middle; text-align: right;">
                                <div style="display: inline-flex; align-items: center; gap: 8px;">
                                    <a href="{{ route('admin.vouchers.edit', $v->id) }}" 
                                       style="background: #F1F4ED; color: var(--text-main); border: 1px solid var(--border-subtle); padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                        <i data-lucide="pencil" style="width: 13px; height: 13px;"></i>
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('admin.vouchers.destroy', $v->id) }}" onsubmit="return confirm('Hapus voucher {{ $v->code }}?');">
                                        @csrf
                                        <button type="submit" 
                                                style="background: #FFF4F2; color: #BA1A1A; border: 1px solid #FFDAD6; padding: 6px 10px; border-radius: 8px; font-size: 12px; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 4px;">
                                            <i data-lucide="trash-2" style="width: 13px; height: 13px;"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 48px; color: var(--text-light);">
                                <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                                    <i data-lucide="ticket" style="width: 44px; height: 44px; color: var(--border-subtle);"></i>
                                    <span style="font-weight: 700; font-size: 15px; color: var(--text-main);">Belum ada voucher diskon</span>
                                    <span style="font-size: 13px; color: var(--text-muted);">Klik tombol "Buat Voucher Baru" untuk mulai membagikan diskon ke pelanggan.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
