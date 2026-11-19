<?php

namespace App\Models;

use App\Enums\AccountType;
use App\Enums\ListingStatus;
use App\Enums\UserStatus;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'address', 'postal_code',
        'nickname', 'avatar_path', 'account_type', 'company_name', 'city', 'province_id',
        'is_federation_member', 'golf_club', 'password', 'apple_id', 'google_id',
        'terms_accepted_at', 'newsletter_consent', 'newsletter_consent_at',
    ];

    protected $hidden = ['password', 'remember_token', 'apple_id', 'google_id'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'terms_accepted_at' => 'datetime',
            'newsletter_consent_at' => 'datetime',
            'password' => 'hashed',
            'account_type' => AccountType::class,
            'status' => UserStatus::class,
            'is_federation_member' => 'boolean',
            'newsletter_consent' => 'boolean',
            'is_admin' => 'boolean',
        ];
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(Listing::class, 'favorites')->withTimestamps();
    }

    public function blockedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_blocks', 'blocker_id', 'blocked_id')->withTimestamps();
    }

    public function isPrivate(): bool
    {
        return $this->account_type === AccountType::Private;
    }

    /** I privati hanno un limite di annunci attivi; pro shop e commercianti no. */
    public function canPublishAnotherListing(): bool
    {
        if (! $this->isPrivate()) {
            return true;
        }

        $active = $this->listings()->where('status', ListingStatus::Published)->count();

        return $active < config('secondamano.listings.max_active_private');
    }

    public function hasBlocked(User $other): bool
    {
        return $this->blockedUsers()->whereKey($other->getKey())->exists();
    }
}
