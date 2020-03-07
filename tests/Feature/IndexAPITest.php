<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexAPITest extends TestCase
{
    use WithoutMiddleware;
    /**
     * check if "Hello World!" message is loaded from db
     * @return void
     */
    public function test_call_index_api()
    {
        $response = $this->json('GET', '/api/social');

        $response->assertSuccessful()
        ->assertJsonFragment([
            'text' => 'Hello World!',
        ]);
    }
}
