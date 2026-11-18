<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    public function test_catalog_is_accessible_by_guest(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Wello Vitality Grocer');
    }
}
