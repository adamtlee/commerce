<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sku',
        'image',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    protected $with = ['inventory'];

    public function inventory(): HasMany
    {
        return $this->hasMany(Inventory::class, 'product_id', 'sku');
    }

    public function waitlists(): HasMany
    {
        return $this->hasMany(Waitlist::class);
    }

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($product) {
            if (request()->has('inventory')) {
                $inventory = request()->input('inventory');
                $product->inventory()->create([
                    'barcode' => $inventory['barcode'] ?? null,
                    'quantity' => $inventory['quantity'] ?? 0,
                    'security_stock' => $inventory['security_stock'] ?? 0,
                    'location' => $inventory['location'],
                    'last_updated' => now(),
                ]);
            }
        });
    }
}
