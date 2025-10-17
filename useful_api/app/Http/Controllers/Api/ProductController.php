<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
        ]);

        $product = $request->user()->products()->create($validated);

        return response()->json($product, 201);
    }

    public function index()
    {
        return response()->json(Product::all());
    }

    public function restock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $request->validate(['quantity' => 'required|integer|min:1']);

        $product->increment('stock', $request->quantity);

        return response()->json([
            'product_id' => $product->id,
            'new_stock' => $product->fresh()->stock,
            'restocked_quantity' => $request->quantity
        ]);
    }
}   