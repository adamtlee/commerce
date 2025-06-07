<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sku',
        'image',
    ];

    protected $with = ['inventory'];

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'product_id', 'sku');
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
