<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->quantity > $product->stock) {
            return response()->json(['error' => 'Stock insuffisant'], 400);
        }

        DB::transaction(function () use ($request, $product) {
            $product->decrement('stock', $request->quantity);
            Order::create([
                'buyer_id' => $request->user()->id,
                'seller_id' => $product->user_id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'total_price' => $product->price * $request->quantity,
                'status' => 'success'
            ]);
        });

        $order = Order::latest()->first();

        return response()->json([
            'order_id' => $order->id,
            'buyer_id' => $order->buyer_id,
            'seller_id' => $order->seller_id,
            'product_id' => $order->product_id,
            'quantity' => $order->quantity,
            'total_price' => $order->total_price,
            'status' => $order->status,
            'created_at' => $order->created_at->toISOString()
        ], 201);
    }
}   