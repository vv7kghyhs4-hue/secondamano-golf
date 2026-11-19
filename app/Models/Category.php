<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'sort_order', 'is_club', 'has_loft', 'is_active'];

    protected function casts(): array
    {
        return ['is_club' => 'boolean', 'has_loft' => 'boolean', 'is_active' => 'boolean'];
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }
}
