<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class InnovationFeaturesTest extends TestCase
{
    use DatabaseMigrations;
    protected $admin;
    protected $customer;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user admin
        $this->admin = User::firstOrCreate(
            ['email' => 'admin_test@toko.com'],
            [
                'name' => 'Admin Tester',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Buat customer
        $this->customer = User::firstOrCreate(
            ['email' => 'customer_test@example.com'],
            [
                'name' => 'Customer Tester',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        // Buat produk sample
        $this->product = Product::firstOrCreate(
            ['name' => 'Apel Fuji Test Unit'],
            [
                'category' => 'Buah Segar',
                'price' => 20000,
                'stock' => 50,
                'description' => 'Apel uji coba',
            ]
        );
    }

    /**
     * TEST FITUR 1: Voucher Diskon Admin & Validasi Checkout
     */
    public function test_voucher_crud_and_validation()
    {
        // 1. Admin membuat voucher
        $response = $this->actingAs($this->admin)->post('/admin/vouchers/store', [
            'code' => 'TESTDISKON20',
            'name' => 'Diskon Uji Coba 20%',
            'type' => 'percentage',
            'reward_amount' => 20,
            'max_discount' => 15000,
            'min_purchase' => 30000,
            'is_active' => '1',
        ]);
        $response->assertRedirect(route('admin.vouchers.index'));

        $voucher = Voucher::where('code', 'TESTDISKON20')->first();
        $this->assertNotNull($voucher);
        $this->assertEquals(20, $voucher->reward_amount);

        // 2. Validasi voucher via AJAX di bawah min_purchase (gagal)
        $resValidateFail = $this->actingAs($this->customer)->postJson('/voucher/apply', [
            'code' => 'TESTDISKON20',
            'subtotal' => 20000,
        ]);
        $resValidateFail->assertStatus(422);

        // 3. Validasi voucher via AJAX di atas min_purchase (sukses)
        $resValidateSuccess = $this->actingAs($this->customer)->postJson('/voucher/apply', [
            'code' => 'TESTDISKON20',
            'subtotal' => 50000, // 20% dari 50.000 = 10.000 (di bawah max 15.000)
        ]);
        $resValidateSuccess->assertStatus(200);
        $resValidateSuccess->assertJson([
            'success' => true,
            'discount_amount' => 10000,
        ]);
    }

    /**
     * TEST FITUR 2: Keranjang Belanja & Checkout Multi-Item
     */
    public function test_cart_workflow_and_checkout()
    {
        // Kosongkan keranjang sebelumnya jika ada
        Cart::where('user_id', $this->customer->id)->delete();

        // 1. Tambah produk ke keranjang
        $resAdd = $this->actingAs($this->customer)->post('/cart/add', [
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);
        $resAdd->assertSessionHas('success');

        $this->assertDatabaseHas('carts', [
            'user_id' => $this->customer->id,
            'product_id' => $this->product->id,
            'quantity' => 2,
        ]);

        // 2. Akses halaman cart
        $resCart = $this->actingAs($this->customer)->get('/cart');
        $resCart->assertStatus(200);
        $resCart->assertSee($this->product->name);

        // 3. Checkout keranjang dengan kupon
        $resCheckout = $this->actingAs($this->customer)->post('/cart/checkout/process', [
            'customer_name' => 'Customer Tester',
            'customer_phone' => '08123456789',
            'customer_address' => 'Jl. Uji Coba No. 1',
            'courier' => 'JNE Reguler',
            'voucher_code' => 'TESTDISKON20',
        ]);

        // Harus redirect ke invoice /berhasil/{id}
        $resCheckout->assertRedirect();
        $this->assertStringContainsString('/berhasil/', $resCheckout->headers->get('Location'));

        // Keranjang harus sudah kosong
        $this->assertEquals(0, Cart::where('user_id', $this->customer->id)->count());
    }

    /**
     * TEST FITUR 3: Diagram & Grafik Admin & User
     */
    public function test_diagram_views_render_properly()
    {
        // 1. Admin Transactions Dashboard dengan Chart.js
        $resAdmin = $this->actingAs($this->admin)->get('/admin/transactions');
        $resAdmin->assertStatus(200);
        $resAdmin->assertSee('Visualisasi &amp; Analitik Penjualan', false);
        $resAdmin->assertSee('chartDailyRevenue');
        $resAdmin->assertSee('chartTopProducts');

        // 2. User Pesanan Saya dengan Chart.js
        // Buat 1 transaksi sukses agar grafik belanja user aktif ditampilkan
        Transaction::create([
            'user_id' => $this->customer->id,
            'invoice_code' => 'INV-TEST-001',
            'product_name' => $this->product->name,
            'customer_name' => $this->customer->name,
            'customer_phone' => '08123456789',
            'customer_address' => 'Jl. Uji Coba',
            'courier' => 'JNE Reguler',
            'quantity' => 2,
            'shipping_cost' => 15000,
            'total_amount' => 55000,
            'status' => 'Shipped',
        ]);

        $resUser = $this->actingAs($this->customer)->get('/pesanan-saya');
        $resUser->assertStatus(200);
        $resUser->assertSee('Statistik Belanja Saya');
        $resUser->assertSee('chartUserMonthly');
    }
}
