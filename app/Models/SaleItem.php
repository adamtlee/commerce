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

                // Update inventory if sale date is after last inventory update
                if ($product->inventory && $saleItem->sale_date > $product->inventory->last_updated) {
                    $product->inventory->decrement('quantity', $saleItem->quantity);
                    $product->inventory->update(['last_updated' => now()]);
                }
            }

            // Calculate total price
            $saleItem->total_price = $saleItem->quantity * $saleItem->unit_price;
        });

        static::updating(function ($saleItem) {
            // Recalculate total price if quantity or unit price changes
            if ($saleItem->isDirty(['quantity', 'unit_price'])) {
                $saleItem->total_price = $saleItem->quantity * $saleItem->unit_price;

                // If quantity changed, update inventory
                if ($saleItem->isDirty('quantity')) {
                    $product = Product::find($saleItem->product_id);
                    if ($product && $product->inventory && $saleItem->sale_date > $product->inventory->last_updated) {
                        $quantityDifference = $saleItem->quantity - $saleItem->getOriginal('quantity');
                        $product->inventory->decrement('quantity', $quantityDifference);
                        $product->inventory->update(['last_updated' => now()]);
                    }
                }
            }
        });

        static::deleting(function ($saleItem) {
            // Restore inventory when sale is deleted
            $product = Product::find($saleItem->product_id);
            if ($product && $product->inventory && $saleItem->sale_date > $product->inventory->last_updated) {
                $product->inventory->increment('quantity', $saleItem->quantity);
                $product->inventory->update(['last_updated' => now()]);
            }
        });
    }
}
