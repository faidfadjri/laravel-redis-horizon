<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\PaymentRequest;
use App\Jobs\ProcessTransaction;
use App\Models\Transaction;

class PaymentController extends Controller
{
    public function payment(PaymentRequest $request)
    {
        $amount      = $request->input('amount');
        $user_id     = auth()->user()?->id;

        $transaction = Transaction::create([
            'status'  => 'pending',
            'amount'  => $amount,
            'user_id' => $user_id
        ]);

        ProcessTransaction::dispatch($transaction);

        return response()->json([
            'message'        => 'Transaction created and is being processed',
            'transaction_id' => $transaction->id,
            'status'         => $transaction->status,
        ], 201);
    }
}
