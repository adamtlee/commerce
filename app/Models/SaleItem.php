<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'product_name',
        'product_sku',
        'quantity',
        'unit_price',
        'total_price',
        'sale_date',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'sale_date' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($saleItem) {
            // Get product details and set unit price
            $product = Product::find($saleItem->product_id);
            if ($product) {
                $saleItem->product_name = $product->name;
                $saleItem->product_sku = $product->sku;
                $saleItem->unit_price = $product->price;
            }

            // Calculate total price
            $saleItem->total_price = $saleItem->quantity * $saleItem->unit_price;
        });

        static::updating(function ($saleItem) {
            // Recalculate total price if quantity or unit price changes
            if ($saleItem->isDirty(['quantity', 'unit_price'])) {
                $saleItem->total_price = $saleItem->quantity * $saleItem->unit_price;
            }
        });
    }
}
