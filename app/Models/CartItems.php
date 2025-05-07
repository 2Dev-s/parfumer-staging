<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItems extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Parfum::class, 'product_id');
    }

    public function getTotalAttribute(): float
    {
        return $this->quantity * $this->price;
    }
}
