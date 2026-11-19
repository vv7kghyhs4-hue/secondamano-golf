<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Posizione pubblicitaria (AdSense sul sito, AdMob nelle app), gestita dal CMS. */
class AdSlot extends Model
{
    public const LIST_FEED = 'list_feed';
    public const GALLERY_END = 'gallery_end';
    public const LISTING_BELOW_GALLERY = 'listing_below_gallery';
    public const LISTING_BEFORE_CONTACT = 'listing_before_contact';

    protected $fillable = ['key', 'name', 'adsense_code', 'admob_unit_id', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    /** Lo spazio si mostra solo se è attivo e ha un codice. */
    public function isRenderable(): bool
    {
        return $this->is_active && filled($this->adsense_code);
    }
}
