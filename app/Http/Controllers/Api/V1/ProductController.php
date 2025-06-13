<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('inventory')->get();
        return response()->json(['data' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'sku' => 'required|string|max:255|unique:products,sku',
            'image' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);
        $product = Product::create($validated);
        $product->load('inventory');
        return response()->json(['data' => $product], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('inventory');
        return response()->json(['data' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'sku' => 'sometimes|required|string|max:255|unique:products,sku,' . $product->id,
            'image' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
        ]);
        $product->update($validated);
        $product->load('inventory');
        return response()->json(['data' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
