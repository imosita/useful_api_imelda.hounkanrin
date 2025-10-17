<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // public function transfer(Request $request)
    // {
    //     $request->validate([
    //         'receiver_id' => 'required|exists:users,id',
    //         'amount' => 'required|numeric|gt:0'
    //     ]);

    //     $senderWallet = $request->user()->wallet;
    //     $receiverWallet = Wallet::firstOrCreate(['user_id' => $request->receiver_id]);

    //     if ($senderWallet->balance < $request->amount) {
    //         return response()->json(['error' => 'Solde insuffisant'], 400);
    //     }

    //     $senderWallet->balance -= $request->amount;
    //     $receiverWallet->balance += $request->amount;
    //     $senderWallet->save();
    //     $receiverWallet->save();

    //     $transaction = Transaction::create([
    //         'sender_id' => $senderWallet->user_id,
    //         'receiver_id' => $receiverWallet->user_id,
    //         'amount' => $request->amount,
    //         'status' => 'success'
    //     ]);

    //     return response()->json([
    //         'transaction_id' => $transaction->id,
    //         'sender_id' => $transaction->sender_id,
    //         'receiver_id' => $transaction->receiver_id,
    //         'amount' => $transaction->amount,
    //         'status' => $transaction->status,
    //         'created_at' => $transaction->created_at->toISOString()
    //     ], 201);
    // }

    public function transfer(Request $request)
{
    $request->validate([
        'receiver_id' => 'required|exists:users,id',
        'amount' => 'required|numeric|gt:0'
    ]);

    $senderWallet = $request->user()->wallet;
    $receiverWallet = Wallet::firstOrCreate(['user_id' => $request->receiver_id]);

    if ($senderWallet->balance < $request->amount) {
        return response()->json(['error' => 'Solde insuffisant'], 400);
    }

    DB::transaction(function () use ($request, $senderWallet, $receiverWallet) {
        $senderWallet->decrement('balance', $request->amount);
        $receiverWallet->increment('balance', $request->amount);

        Transaction::create([
            'sender_id' => $senderWallet->user_id,
            'receiver_id' => $receiverWallet->user_id,
            'amount' => $request->amount,
            'status' => 'success'
        ]);
    });

    return response()->json([
        'transaction_id' => Transaction::latest()->first()->id,
        'sender_id' => $senderWallet->user_id,
        'receiver_id' => $receiverWallet->user_id,
        'amount' => $request->amount,
        'status' => 'success',
        'created_at' => now()->toISOString()
    ], 201);
}   
}   


