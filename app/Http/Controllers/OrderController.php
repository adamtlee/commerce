<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'note' => 'nullable|string',
        ]);

        $order = Order::create([
            'product_id' => $validated['product_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'],
            'note' => $validated['note'] ?? null,
            'status' => 'pending',
            'user_id' => auth()->check() ? auth()->id() : null,
        ]);

        return redirect()->back()->with('success', 'Your order has been submitted and is pending approval.');
    }
}
