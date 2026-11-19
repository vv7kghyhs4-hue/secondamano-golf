<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Chat tra un acquirente e il venditore, legata a un annuncio. */
class Conversation extends Model
{
    protected $fillable = ['listing_id', 'buyer_id', 'seller_id', 'last_message_at', 'buyer_read_at', 'seller_read_at', 'closed_at'];

    protected function casts(): array
    {
        return [
            'last_message_at' => 'datetime',
            'buyer_read_at' => 'datetime',
            'seller_read_at' => 'datetime',
            'closed_at' => 'datetime',
        ];
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->oldest();
    }

    public function involves(User $user): bool
    {
        return in_array($user->getKey(), [$this->buyer_id, $this->seller_id], true);
    }
}
