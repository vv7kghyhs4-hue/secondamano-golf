<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // [nome, è un bastone (mano/flex), ha il loft]
        $categories = [
            ['Set completi', true, false],
            ['Legni e driver', true, true],
            ['Ibridi', true, true],
            ['Ferri', true, false],
            ['Wedge', true, true],
            ['Putter', true, false],
            ['Sacche', false, false],
            ['Carrelli', false, false],
            ['Palline', false, false],
            ['Elettronica (telemetri, GPS, orologi)', false, false],
            ['Abbigliamento e scarpe', false, false],
            ['Accessori vari', false, false],
        ];

        foreach ($categories as $i => [$name, $isClub, $hasLoft]) {
            Category::updateOrCreate(
                ['slug' => Str::slug(Str::before($name, ' ('))],
                ['name' => $name, 'sort_order' => $i + 1, 'is_club' => $isClub, 'has_loft' => $hasLoft],
            );
        }
    }
}
