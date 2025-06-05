<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'sku',
        'tax_status',
        'tax_class',
        'image',
    ];
    // archive-boxs

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'product_id', 'sku');
    }
}
