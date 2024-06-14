<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testTransactionHistory()
    {
        $user = User::factory()->create();
        Transaction::factory()->count(5)->create(['user_id' => $user->id]);

        Passport::actingAs($user);

        $response = $this->getJson('/api/v1/transaction/history');

        $response->assertStatus(200);
    }

    public function testTransactionSummary()
    {
        $user = User::factory()->create();
        Transaction::factory()->count(5)->create(['user_id' => $user->id]);

        Passport::actingAs($user);

        $response = $this->getJson('/api/v1/transaction/summary');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'total_transactions',
                    'average_amount',
                    'highest_transaction',
                    'lowest_transaction',
                    'longest_name_transaction',
                    'status_distribution'
                ]
            ]);
    }
}
