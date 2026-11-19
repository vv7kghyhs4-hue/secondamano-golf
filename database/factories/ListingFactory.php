<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Enums\ListingCondition;
use App\Enums\ListingStatus;
use App\Models\Category;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<Listing> */
class ListingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => fn () => Category::query()->inRandomOrder()->value('id')
                ?? Category::create(['name' => 'Ferri', 'slug' => 'ferri-'.Str::random(4)])->id,
            'brand_other' => 'Marca di prova',
            'title' => Str::limit(fake()->sentence(4), 47),
            'description' => fake()->paragraph(),
            'condition' => ListingCondition::Used,
            'price' => fake()->randomFloat(2, 10, 900),
            'currency' => fake()->randomElement(Currency::cases()),
            'city' => fake()->city(),
            'province_id' => fn (array $a) => User::find($a['user_id'])?->province_id,
            'status' => ListingStatus::Draft,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => [
            'status' => ListingStatus::Published,
            'published_at' => now(),
            'expires_at' => now()->addDays(60),
        ]);
    }
}
