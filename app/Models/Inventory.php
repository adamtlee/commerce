<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $fillable = [
        'product_id',
        'barcode',
        'quantity',
        'security_stock',
        'location',
        'last_updated',
    ];

    protected $casts = [
        'last_updated' => 'datetime',
        'quantity' => 'integer',
        'security_stock' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'sku');
    }
}
