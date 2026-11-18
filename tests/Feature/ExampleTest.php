<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    public function test_catalog_is_accessible_by_guest_shows_welcome(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Selamat Datang di Wello!');
        $response->assertDontSee('Pasar Segar &amp; Organik', false);
    }

    public function test_catalog_shows_user_name_when_authenticated(): void
    {
        $user = User::factory()->create(['name' => 'Adinda Permata']);

        $response = $this->actingAs($user)->get('/');

        $response->assertOk();
        $response->assertSee('Selamat Datang, Adinda Permata!');
        $response->assertDontSee('Pasar Segar &amp; Organik', false);
    }
}
