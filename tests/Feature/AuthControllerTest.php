<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Cookie;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_login_page_renders_the_wello_sign_in_form(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('Masuk');
        $response->assertSee('name="email"', false);
        $response->assertDontSee('name="remember"', false);
    }

    public function test_session_cookie_expires_when_the_browser_closes(): void
    {
        $response = $this->get('/login');

        $sessionCookie = collect($response->headers->getCookies())
            ->first(fn (Cookie $cookie): bool => $cookie->getName() === config('session.cookie'));

        $this->assertNotNull($sessionCookie);
        $this->assertSame(0, $sessionCookie->getExpiresTime());
    }

    public function test_register_page_renders_the_account_creation_form(): void
    {
        $response = $this->get('/register');

        $response->assertOk();
        $response->assertSee('Daftar');
        $response->assertSee('name="password_confirmation"', false);
    }

    public function test_registration_creates_a_regular_user_and_redirects_to_login(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Regular User',
            'email' => 'regular@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'email' => 'regular@example.com',
            'role' => 'customer',
        ]);
        $this->assertGuest();

        $user = User::where('email', 'regular@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('password123', $user->password));
        $this->assertStringStartsWith('$2y$', $user->password);
    }

    public function test_regular_user_login_redirects_to_the_catalog(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('catalog'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_incorrect_password_returns_to_login_with_an_error_message(): void
    {
        $user = User::factory()->create();

        $response = $this->from('/login')
            ->followingRedirects()
            ->post('/login', [
                'email' => $user->email,
                'password' => 'incorrect-password',
            ]);

        $response->assertOk();
        $response->assertSee('Kredensial tidak cocok. Periksa kembali email dan kata sandi Anda.');
        $this->assertGuest();
    }

    public function test_admin_login_redirects_to_seller_center(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.transactions'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_regular_user_sees_no_admin_link_and_cannot_access_admin_routes(): void
    {
        $user = User::factory()->create();

        $catalogResponse = $this->actingAs($user)->get('/');
        $catalogResponse->assertOk();
        $catalogResponse->assertDontSee('Seller Center');
        $catalogResponse->assertSee('Keluar');

        $adminResponse = $this->get('/admin/products');
        $adminResponse->assertForbidden();

        $logoutResponse = $this->post(route('logout'));
        $logoutResponse->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_admin_sees_admin_link_and_can_access_admin_routes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $catalogResponse = $this->actingAs($admin)->get('/');
        $catalogResponse->assertOk();
        $catalogResponse->assertSee('Seller Center');

        $adminResponse = $this->get('/admin/products');
        $adminResponse->assertOk();
        $adminResponse->assertSee('Keluar');

        $logoutResponse = $this->post(route('logout'));
        $logoutResponse->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
