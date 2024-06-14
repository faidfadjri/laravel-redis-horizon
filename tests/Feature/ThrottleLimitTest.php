<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ThrottleLimitTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testThrottleLimit()
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        for ($i = 0; $i < 100; $i++) {
            $response = $this->getJson('/api/v1/transaction/history');
            $response->assertStatus(200);
        }

        $response = $this->getJson('/api/v1/transaction/history');
        $response->assertStatus(429); // Too Many Requests
    }
}
