<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Waitlist extends Model
{
    protected $fillable = [
        'product_id',
        'email',
        'name',
        'notes',
        'status',
        'notified_at',
        'requested_quantity',
    ];

    protected $casts = [
        'notified_at' => 'datetime',
        'requested_quantity' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
} 