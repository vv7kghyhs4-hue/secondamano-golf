<?php

namespace Database\Seeders;

use App\Models\AdSlot;
use App\Models\Setting;
use Illuminate\Database\Seeder;

/** Le quattro posizioni pubblicitarie decise nell'analisi; i codici si inseriscono dal CMS. */
class AdSlotSeeder extends Seeder
{
    public function run(): void
    {
        $slots = [
            AdSlot::LIST_FEED => 'Liste (home e ricerca), ogni N annunci',
            AdSlot::GALLERY_END => 'Fine gallery, dopo l\'ultima foto',
            AdSlot::LISTING_BELOW_GALLERY => 'Pagina annuncio, sotto la gallery',
            AdSlot::LISTING_BEFORE_CONTACT => 'Pagina annuncio, prima di "Contatta il venditore"',
        ];

        foreach ($slots as $key => $name) {
            AdSlot::firstOrCreate(['key' => $key], ['name' => $name]);
        }

        if (Setting::get('ads_list_frequency') === null) {
            Setting::put('ads_list_frequency', config('secondamano.ads.list_frequency'));
        }
    }
}
