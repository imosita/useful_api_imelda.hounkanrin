<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;

class WalletController extends Controller
{
    public function show(Request $request)
    {
        $wallet = $request->user()->wallet;
        return response()->json([
            'user_id' => $wallet->user_id,
            'balance' => $wallet->balance
        ]);
    }

    public function topUp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|gt:0|max:10000'
        ]);

        $wallet = $request->user()->wallet;
        $wallet->balance += $request->amount;
        $wallet->save();

        return response()->json([
            'user_id' => $wallet->user_id,
            'balance' => $wallet->balance,
            'topup_amount' => $request->amount,
            'created_at' => now()->toISOString()
        ], 201);
    }

    public function transactions(Request $request)
    {
        $transactions = $request->user()->sentTransactions()->with('receiver')->get();
        return response()->json($transactions);
    }
}   
