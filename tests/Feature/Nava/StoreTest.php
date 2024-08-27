<?php

namespace Tests\Feature\Nava;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    /**
     * @test
     * 
     * A basic feature test example.
     */
    public function storeNava(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
