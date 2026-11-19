<?php

namespace Database\Factories;

use App\Enums\AccountType;
use App\Models\Province;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/** @extends Factory<User> */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone' => fake()->numerify('+41 79 ### ## ##'),
            'address' => fake()->streetAddress(),
            'postal_code' => fake()->numerify('69##'),
            'nickname' => fake()->unique()->userName(),
            'account_type' => AccountType::Private,
            'city' => fake()->city(),
            'province_id' => fn () => Province::query()->inRandomOrder()->value('id')
                ?? Province::create(['code' => 'TI', 'name' => 'Canton Ticino', 'country' => 'CH'])->id,
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'terms_accepted_at' => now(),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn () => ['email_verified_at' => null]);
    }

    public function proshop(): static
    {
        return $this->state(fn () => ['account_type' => AccountType::Proshop, 'company_name' => fake()->company()]);
    }
}
