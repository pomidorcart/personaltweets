<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchAPITest extends TestCase
{
    use WithoutMiddleware;
    /**
     * check to see if "api/social/fetch" sends success
     * @return void
     */
    public function test_call_social_fetch_api()
    {
        $this->json('GET', 'api/social/fetch')
        ->assertJson(['msg'=>'ssuccess', 'code'=>200]);
    }
}
