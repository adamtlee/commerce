<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesChannel extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'type',
        'status',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function saleItems(): HasMany
    {
        return $this->hasMany(SaleItem::class, 'channel_id');
    }
} 