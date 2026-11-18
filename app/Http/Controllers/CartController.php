<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Tampilkan halaman keranjang belanja
     */
    public function index()
    {
        $userId = auth()->id();
        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return ($item->product->price ?? 0) * $item->quantity;
        });

        $totalItems = $cartItems->sum('quantity');

        return view('cart', compact('cartItems', 'subtotal', 'totalItems'));
    }

    /**
     * Tambah produk ke keranjang belanja
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1',
        ]);

        $userId = auth()->id();
        $productId = $request->product_id;
        $qtyToAdd = (int) ($request->quantity ?? 1);

        $product = Product::findOrFail($productId);

        if ($product->stock <= 0) {
            return back()->with('error', 'Maaf, stok produk ' . $product->name . ' sedang habis.');
        }

        $cart = Cart::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($cart) {
            $newQty = $cart->quantity + $qtyToAdd;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Maksimal jumlah di keranjang adalah ' . $product->stock . ' pcs sesuai sisa stok.');
            }
            $cart->update(['quantity' => $newQty]);
        } else {
            if ($qtyToAdd > $product->stock) {
                return back()->with('error', 'Jumlah pesanan melebihi sisa stok yang tersedia (' . $product->stock . ' pcs).');
            }
            Cart::create([
                'user_id'    => $userId,
                'product_id' => $productId,
                'quantity'   => $qtyToAdd,
            ]);
        }

        return back()->with('success', $product->name . ' berhasil ditambahkan ke keranjang belanja!');
    }

    /**
     * Perbarui jumlah item di keranjang
     */
    public function update(Request $request, $id)
    {
        $cart = Cart::where('user_id', auth()->id())->where('id', $id)->firstOrFail();

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $product = $cart->product;
        if ($request->quantity > $product->stock) {
            return back()->with('error', 'Jumlah melebihi stok yang tersedia (' . $product->stock . ' pcs).');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Jumlah ' . $product->name . ' berhasil diperbarui.');
    }

    /**
     * Hapus item dari keranjang
     */
    public function remove($id)
    {
        $cart = Cart::where('user_id', auth()->id())->where('id', $id)->firstOrFail();
        $name = $cart->product->name ?? 'Produk';
        $cart->delete();

        return back()->with('success', $name . ' telah dihapus dari keranjang.');
    }

    /**
     * Kosongkan seluruh keranjang belanja user
     */
    public function clear()
    {
        Cart::where('user_id', auth()->id())->delete();
        return redirect()->route('cart.index')->with('success', 'Keranjang belanja telah dikosongkan.');
    }

    /**
     * Tampilkan formulir checkout multi-item dari keranjang
     */
    public function showCheckout()
    {
        $userId = auth()->id();
        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        // Validasi stok sebelum checkout
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')->with('error', 'Stok untuk ' . $item->product->name . ' tersisa ' . $item->product->stock . ' pcs. Silakan sesuaikan jumlah di keranjang.');
            }
        }

        $subtotal = $cartItems->sum(function ($item) {
            return ($item->product->price ?? 0) * $item->quantity;
        });

        return view('cart_checkout', compact('cartItems', 'subtotal'));
    }

    /**
     * Proses transaksi checkout multi-item
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'customer_name'    => 'required|string|max:255',
            'customer_phone'   => 'required|string|max:30',
            'customer_address' => 'required|string',
            'courier'          => 'required|string',
        ]);

        $userId = auth()->id();
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        // Cek ketersediaan stok semua item
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')->with('error', 'Stok ' . $item->product->name . ' tidak mencukupi (sisa: ' . $item->product->stock . ').');
            }
        }

        // Ongkos kirim
        $shipping_cost = 15000;
        if ($request->courier == 'J&T Express') {
            $shipping_cost = 20000;
        } elseif ($request->courier == 'SiCepat BEST') {
            $shipping_cost = 25000;
        }

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Validasi Voucher Diskon jika ada
        $discountAmount = 0;
        $voucherId = null;
        $voucherCode = null;

        if ($request->filled('voucher_code')) {
            $code = strtoupper(trim($request->voucher_code));
            $voucher = Voucher::where('code', $code)->first();

            if ($voucher && $voucher->isValidFor($subtotal)) {
                $discountAmount = $voucher->calculateDiscount($subtotal);
                $voucherId = $voucher->id;
                $voucherCode = $voucher->code;
                $voucher->increment('used_count');
            }
        }

        $totalAmount = max(0, $subtotal + $shipping_cost - $discountAmount);
        $invoiceCode = 'INV-2026-' . rand(1000, 9999);

        // Buat ringkasan nama produk untuk tampilan cepat
        $itemNames = $cartItems->pluck('product.name')->toArray();
        $firstItemName = $itemNames[0] ?? 'Produk Segar';
        $otherCount = count($itemNames) - 1;
        $summaryProductName = $otherCount > 0 
            ? $firstItemName . ' (+' . $otherCount . ' item lainnya)'
            : $firstItemName;

        $totalQuantity = $cartItems->sum('quantity');

        // Gunakan DB Transaction agar konsisten
        $transaction = DB::transaction(function () use (
            $userId, $invoiceCode, $summaryProductName, $request,
            $shipping_cost, $discountAmount, $totalAmount, $voucherId, $voucherCode,
            $totalQuantity, $cartItems
        ) {
            $trx = Transaction::create([
                'user_id'          => $userId,
                'voucher_id'       => $voucherId,
                'voucher_code'     => $voucherCode,
                'invoice_code'     => $invoiceCode,
                'product_id'       => $cartItems[0]->product_id ?? null,
                'product_name'     => $summaryProductName,
                'customer_name'    => $request->customer_name,
                'customer_phone'   => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'courier'          => $request->courier,
                'quantity'         => $totalQuantity,
                'shipping_cost'    => $shipping_cost,
                'discount_amount'  => $discountAmount,
                'total_amount'     => $totalAmount,
                'status'           => 'Pending',
            ]);

            // Simpan rincian per produk ke transaction_items & kurangi stok
            foreach ($cartItems as $c) {
                $p = $c->product;
                $itemSubtotal = $p->price * $c->quantity;

                TransactionItem::create([
                    'transaction_id' => $trx->id,
                    'product_id'     => $p->id,
                    'product_name'   => $p->name,
                    'price'          => $p->price,
                    'quantity'       => $c->quantity,
                    'subtotal'       => $itemSubtotal,
                ]);

                // Kurangi stok produk
                $p->decrement('stock', $c->quantity);
            }

            // Hapus isi keranjang belanja user
            Cart::where('user_id', $userId)->delete();

            return $trx;
        });

        return redirect('/berhasil/' . $transaction->id);
    }
}
