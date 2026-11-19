<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\Hand;
use App\Enums\ListingCondition;
use App\Enums\ListingStatus;
use App\Enums\ShaftFlex;
use Database\Factories\ListingFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    /** @use HasFactory<ListingFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'brand_id', 'brand_other', 'title', 'description', 'condition',
        'price', 'currency', 'is_free', 'is_negotiable', 'shipping_available', 'shipping_cost',
        'hand', 'shaft_flex', 'loft', 'show_phone', 'city', 'province_id',
    ];

    protected function casts(): array
    {
        return [
            'condition' => ListingCondition::class,
            'status' => ListingStatus::class,
            'currency' => Currency::class,
            'hand' => Hand::class,
            'shaft_flex' => ShaftFlex::class,
            'price' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'loft' => 'decimal:1',
            'is_free' => 'boolean',
            'is_negotiable' => 'boolean',
            'shipping_available' => 'boolean',
            'show_phone' => 'boolean',
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
            'sold_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ListingPhoto::class)->orderBy('sort_order');
    }

    public function mainPhoto(): HasOne
    {
        return $this->hasOne(ListingPhoto::class)->where('is_main', true);
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    /** Annunci visibili nelle liste pubbliche: pubblicati e non scaduti. */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('status', ListingStatus::Published)
            ->where(fn (Builder $q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()));
    }

    public function brandName(): ?string
    {
        return $this->brand?->name ?? $this->brand_other;
    }

    /** Pubblica l'annuncio e fissa la scadenza a 60 giorni. */
    public function publish(): void
    {
        $this->forceFill([
            'status' => ListingStatus::Published,
            'published_at' => now(),
            'expires_at' => now()->addDays(config('secondamano.listings.duration_days')),
        ])->save();
    }

    public function markAsSold(): void
    {
        $this->forceFill(['status' => ListingStatus::Sold, 'sold_at' => now()])->save();
    }
}
