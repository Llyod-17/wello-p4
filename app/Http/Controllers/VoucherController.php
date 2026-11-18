<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    // ==========================================
    // BACK-OFFICE ADMIN: CRUD VOUCHER
    // ==========================================

    public function index()
    {
        $vouchers = Voucher::latest()->get();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'          => 'required|string|max:50|unique:vouchers,code',
            'name'          => 'required|string|max:150',
            'type'          => 'required|in:percentage,fixed',
            'reward_amount' => 'required|numeric|min:1',
            'max_discount'  => 'nullable|numeric|min:0',
            'min_purchase'  => 'nullable|numeric|min:0',
            'quota'         => 'nullable|integer|min:1',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
        ]);

        Voucher::create([
            'code'          => strtoupper(trim($request->code)),
            'name'          => $request->name,
            'type'          => $request->type,
            'reward_amount' => $request->reward_amount,
            'max_discount'  => $request->filled('max_discount') ? $request->max_discount : null,
            'min_purchase'  => $request->filled('min_purchase') ? $request->min_purchase : 0,
            'quota'         => $request->filled('quota') ? $request->quota : null,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'is_active'     => $request->has('is_active'),
        ]);

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher diskon baru berhasil diterbitkan!');
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);

        $request->validate([
            'code'          => 'required|string|max:50|unique:vouchers,code,' . $voucher->id,
            'name'          => 'required|string|max:150',
            'type'          => 'required|in:percentage,fixed',
            'reward_amount' => 'required|numeric|min:1',
            'max_discount'  => 'nullable|numeric|min:0',
            'min_purchase'  => 'nullable|numeric|min:0',
            'quota'         => 'nullable|integer|min:1',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
        ]);

        $voucher->update([
            'code'          => strtoupper(trim($request->code)),
            'name'          => $request->name,
            'type'          => $request->type,
            'reward_amount' => $request->reward_amount,
            'max_discount'  => $request->filled('max_discount') ? $request->max_discount : null,
            'min_purchase'  => $request->filled('min_purchase') ? $request->min_purchase : 0,
            'quota'         => $request->filled('quota') ? $request->quota : null,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
            'is_active'     => $request->has('is_active'),
        ]);

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Data voucher ' . $voucher->code . ' berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        $code = $voucher->code;
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher ' . $code . ' berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->is_active = !$voucher->is_active;
        $voucher->save();

        return back()->with('success', 'Status voucher ' . $voucher->code . ' berhasil diubah menjadi: ' . ($voucher->is_active ? 'Aktif' : 'Non-aktif'));
    }

    // ==========================================
    // FRONT-END: AJAX CHECK VOUCHER
    // ==========================================

    public function validateVoucher(Request $request)
    {
        $request->validate([
            'code'     => 'required|string',
            'subtotal' => 'required|numeric|min:0',
        ]);

        $code = strtoupper(trim($request->code));
        $subtotal = (int) $request->subtotal;

        $voucher = Voucher::where('code', $code)->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Kode voucher tidak ditemukan atau tidak valid.'
            ], 404);
        }

        $errorMsg = null;
        if (!$voucher->isValidFor($subtotal, $errorMsg)) {
            return response()->json([
                'success' => false,
                'message' => $errorMsg
            ], 422);
        }

        $discount = $voucher->calculateDiscount($subtotal);

        return response()->json([
            'success'         => true,
            'message'         => 'Voucher "' . $voucher->name . '" berhasil digunakan!',
            'voucher_id'      => $voucher->id,
            'voucher_code'    => $voucher->code,
            'discount_amount' => $discount,
            'discount_formatted' => 'Rp ' . number_format($discount, 0, ',', '.'),
        ]);
    }
}
