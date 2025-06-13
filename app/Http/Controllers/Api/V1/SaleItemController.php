<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\SaleItem;
use Illuminate\Http\Request;

class SaleItemController extends Controller
{
    public function index()
    {
        $saleItems = SaleItem::with('product')->get();
        return response()->json(['data' => $saleItems]);
    }

    public function show(SaleItem $saleItem)
    {
        $saleItem->load('product');
        return response()->json(['data' => $saleItem]);
    }
} 