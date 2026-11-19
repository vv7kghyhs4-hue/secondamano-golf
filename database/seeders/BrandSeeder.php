<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/** Elenco iniziale delle marche; si amplia dal CMS. Chi non trova la marca sceglie "Altro". */
class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Adams', 'adidas', 'Ben Hogan', 'Benross', 'Big Max', 'Bridgestone', 'Bushnell', 'Callaway',
            'Cleveland', 'Clicgear', 'Cobra', 'Ecco', 'FootJoy', 'Galvin Green', 'Garmin', 'Honma',
            'Inesis', 'Lynx', 'Mizuno', 'Motocaddy', 'Nike', 'Nikon', 'Odyssey', 'Ping', 'Powakaddy',
            'Puma', 'PXG', 'Scotty Cameron', 'Srixon', 'Sun Mountain', 'TaylorMade', 'Titleist',
            'Tour Edge', 'Under Armour', 'Vokey', 'Wilson', 'XXIO', 'Yonex',
        ];

        foreach ($brands as $name) {
            Brand::updateOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
        }
    }
}
