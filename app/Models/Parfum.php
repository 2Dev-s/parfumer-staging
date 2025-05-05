<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main')
            ->singleFile()
            ->useFallbackUrl('/images/default-parfum.jpg')
            ->useFallbackPath(public_path('/images/default-parfum.jpg'));

        $this->addMediaCollection('gallery')
            ->useDisk('public'); // or whatever disk you prefer
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->performOnCollections('main', 'gallery');

        $this->addMediaConversion('medium')
            ->width(600)
            ->height(600)
            ->performOnCollections('main', 'gallery');
    }

    public function getMainImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('main', 'medium') ?: '/images/default-parfum.jpg';
    }

    public function getGalleryImagesAttribute(): array
    {
        return $this->getMedia('gallery')->map(function ($media) {
            return [
                'original' => $media->getUrl(),
                'thumb' => $media->getUrl('thumb'),
                'medium' => $media->getUrl('medium')
            ];
        })->toArray();
    }
}
