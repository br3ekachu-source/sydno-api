<?php

namespace Database\Factories;

use App\Models\Advert;
use App\Models\AdvertLegalInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdvertLegalInformation>
 */
class AdvertLegalInformationFactory extends Factory
{
    protected $model = AdvertLegalInformation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $wasRegistered = fake()->boolean();
        $registerValidUntil = !$wasRegistered ? null : fake()->date();
        $ids = Advert::all()->pluck('id');

        return [
            'advert_id' => $this->faker->unique()->randomElement($ids),
            'flag' => fake()->countryCode(),
            'exploitation_type' => fake()->numberBetween(0, 1),
            'class_formula' => fake()->swiftBicNumber(),
            'wave_limit' => fake()->randomFloat(1, 0, 3.5),
            'ice_strengthening' => fake()->boolean(),
            'type' => fake()->numberBetween(0, 3),
            'purpose' => fake()->word(),
            'was_registered' => $wasRegistered,
            'register_valid_until' => $registerValidUntil,
            'vessel_status' => fake()->numberBetween(0, 2),
            'project_number' => fake()->swiftBicNumber(),
            'building_number' => fake()->swiftBicNumber(),
            'building_year' => fake()->year(2024),
            'building_country' => fake()->countryCode(),
            'port_address' => fake()->address(),
            'vessel_location' => fake()->city(),
            'imo_number' => fake()->swiftBicNumber()
        ];
    }
}
