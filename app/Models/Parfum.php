<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Parfum extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    protected $table = 'parfums';

    protected $fillable = [
        'name',
        'brand_id',
        'description',
        'price',
        'stock',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
