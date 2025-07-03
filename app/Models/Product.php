<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Arr;

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
            $data = request()->all();
            $inventory = [
                'barcode' => Arr::get($data, 'inventory.barcode'),
                'quantity' => Arr::get($data, 'inventory.quantity', 0),
                'security_stock' => Arr::get($data, 'inventory.security_stock', 0),
                'location' => Arr::get($data, 'inventory.location'),
                'last_updated' => now(),
            ];

            // Only create if at least one inventory field is present
            if (
                Arr::get($data, 'inventory.barcode') !== null ||
                Arr::get($data, 'inventory.quantity') !== null ||
                Arr::get($data, 'inventory.security_stock') !== null ||
                Arr::get($data, 'inventory.location') !== null
            ) {
                $product->inventory()->create(array_merge(['product_id' => $product->sku], $inventory));
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
