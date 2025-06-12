<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class, 'product_id', 'sku');
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
                    'product_id' => $product->sku,
                    'barcode' => $inventory['barcode'] ?? null,
                    'quantity' => $inventory['quantity'] ?? 0,
                    'security_stock' => $inventory['security_stock'] ?? 0,
                    'location' => $inventory['location'],
                    'last_updated' => now(),
                ]);
            }
        });

        static::saving(function ($product) {
            // Get inventory data from the request or from the data array
            $inventoryData = request()->input('inventory') ?? request()->input('data.inventory');
            
            if ($inventoryData) {
                // If the product already exists, update its inventory
                if ($product->exists) {
                    $product->inventory()->updateOrCreate(
                        ['product_id' => $product->sku],
                        [
                            'barcode' => $inventoryData['barcode'] ?? null,
                            'quantity' => $inventoryData['quantity'] ?? 0,
                            'security_stock' => $inventoryData['security_stock'] ?? 0,
                            'location' => $inventoryData['location'],
                            'last_updated' => now(),
                        ]
                    );
                }
            }
        });
    }
}
