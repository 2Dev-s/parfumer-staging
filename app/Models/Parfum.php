<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Parfum extends Model implements HasMedia
{
    use InteractsWithMedia, HasFactory;

    protected $table = 'parfums';

    protected $fillable = [
        'name',
        'slug',
        'brand_id',
        'category_id',
        'description',
        'price',
        'stock',
        'sex',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'price' => 'decimal:2',
    ];

    protected $appends = [
        'main_image_url',
        'gallery_images'
    ];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Keep only ONE registerMediaCollections method
    public function registerMediaCollections(): void
    {
        // Main image collection
        $this->addMediaCollection('main')
            ->singleFile()
            ->useDisk('public');

        // Gallery images collection
        $this->addMediaCollection('gallery')
            ->useDisk('public');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        // Define conversions for both collections
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->performOnCollections('images', 'gallery');

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(600)
            ->performOnCollections('images', 'gallery');
    }

    public function getMainImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('images', 'medium')
            ?? '/images/default-parfum.jpg';
    }

    public function getGalleryImagesAttribute(): array
    {
        return $this->getMedia('images')->map(function ($media) {
            return [
                'url' => $media->getFullUrl('medium'),
                'thumb' => $media->getFullUrl('thumb'),
            ];
        })->toArray();
    }


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;

        $slug = Str::slug($value);
        $counter = 1;

        while (static::where('slug', $slug)
            ->where('id', '!=', $this->id ?? null)
            ->exists()) {
            $slug = Str::slug($value) . '-' . $counter;
            $counter++;
        }

        $this->attributes['slug'] = $slug;
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItems::class, 'product_id');
    }
}
