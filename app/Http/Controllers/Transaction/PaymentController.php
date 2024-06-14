<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\PaymentRequest;
use App\Jobs\ProcessTransaction;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function payment(PaymentRequest $request)
    {
        try {
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
        } catch (Exception $err) {
            return response()->json([
                'message' => 'something went wrong',
                'error'   => $err->getMessage()
            ], 500);
        }
    }


    public function history()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated',
                ], 401);
            }

            $transactionHistory = Transaction::where('user_id', $user->id)->paginate(10);

            return response()->json([
                'message' => "Getting user's transaction history succeeded",
                'data'    => $transactionHistory
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $err->getMessage()
            ], 500);
        }
    }



    public function summary()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'message' => 'User not authenticated',
                ], 401);
            }

            $transactions = Transaction::where('user_id', $user->id)->with('user')->get();

            $totalTransactions = $transactions->count();
            $averageAmount = $transactions->avg('amount');
            $highestTransaction = $transactions->sortByDesc('amount')->first();
            $lowestTransaction = $transactions->sortBy('amount')->first();
            $longestNameTransaction = $transactions->sortByDesc(function ($transaction) {
                return strlen($transaction->user->name);
            })->first();

            $statusDistribution = $transactions->groupBy('status')->map(function ($group) {
                return $group->count();
            });

            return response()->json([
                'message' => "Getting user's transaction summary succeeded",
                'data' => [
                    'total_transactions' => $totalTransactions,
                    'average_amount' => $averageAmount,
                    'highest_transaction' => $highestTransaction,
                    'lowest_transaction' => $lowestTransaction,
                    'longest_name_transaction' => array_merge(
                        $longestNameTransaction->toArray(),
                        ['user_name' => $longestNameTransaction->user->name]
                    ),
                    'status_distribution' => [
                        'pending' => $statusDistribution->get('pending', 0),
                        'completed' => $statusDistribution->get('completed', 0),
                        'failed' => $statusDistribution->get('failed', 0),
                    ]
                ]
            ], 200);
        } catch (Exception $err) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $err->getMessage()
            ], 500);
        }
    }
}
