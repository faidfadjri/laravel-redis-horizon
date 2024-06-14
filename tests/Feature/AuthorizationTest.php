<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function testUnauthorizedAccess()
    {
        $response = $this->getJson('/api/v1/transaction/history');
        $response->assertStatus(401); // Unauthorized
    }

    public function testAuthorizedAccess()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->getJson('/api/v1/transaction/history');
        $response->assertStatus(200);
    }
}
