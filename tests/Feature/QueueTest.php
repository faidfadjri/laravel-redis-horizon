<?php

namespace Tests\Feature;

use App\Jobs\ProcessTransaction;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class QueueTest extends TestCase
{
    use RefreshDatabase;

    public function testTransactionProcessingJobDispatched()
    {
        Queue::fake();

        $user        = User::factory()->create();
        $transaction = Transaction::factory()->create(['user_id' => $user->id]);

        ProcessTransaction::dispatch($transaction);

        Queue::assertPushed(ProcessTransaction::class, function ($job) use ($transaction) {
            return $job->transaction->is($transaction);
        });
    }
}
