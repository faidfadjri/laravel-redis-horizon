<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $transaction;
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Simulate transaction processing
        $success = rand(0, 1); // Randomly simulate success or failure

        Log::debug("Running queue job");
        if ($success) {
            $this->transaction->update(['status' => 'completed']);
        } else {
            $this->transaction->update(['status' => 'failed']);
        }
    }
}
