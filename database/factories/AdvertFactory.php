<?php

namespace Database\Factories;

use App\Http\Services\AdvertState;
use App\Http\Services\Consts;
use App\Models\Advert;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advert>
 */
class AdvertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(1, 10),
            'registration_number' => fake()->swiftBicNumber(),
            'price' => fake()->numberBetween(1000000, 999999999),
            'state' => AdvertState::Active,
            'header' => fake()->sentence(3, true),
            'description' => fake()->text(),
            'phone_number' => fake()->phoneNumber(),
            'views' => fake()->numberBetween(0, 5000)
        ];
    }
}
