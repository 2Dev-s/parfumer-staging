<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'active',
    ];

    public function parfumes(): HasMany
    {
        return $this->hasMany(Parfum::class);
    }
}
