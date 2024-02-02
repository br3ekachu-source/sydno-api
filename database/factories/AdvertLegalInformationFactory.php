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
            'name' => fake()->sentence(3, true),
            'flag' => strtolower(fake()->countryCode()),
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
            'building_year' => fake()->year(),
            'building_place' => fake()->city(),
            'port_address' => '{"value":"\u0421\u0430\u0440\u0430\u0442\u043e\u0432\u0441\u043a\u0430\u044f \u043e\u0431\u043b, \u0433 \u042d\u043d\u0433\u0435\u043b\u044c\u0441","city":"\u042d\u043d\u0433\u0435\u043b\u044c\u0441","country":"\u0420\u043e\u0441\u0441\u0438\u044f","region":"\u0421\u0430\u0440\u0430\u0442\u043e\u0432\u0441\u043a\u0430\u044f"}',
            'vessel_location' => '{"value":"\u0433 \u041c\u043e\u0441\u043a\u0432\u0430","city":"\u041c\u043e\u0441\u043a\u0432\u0430","country":"\u0420\u043e\u0441\u0441\u0438\u044f","region":"\u041c\u043e\u0441\u043a\u0432\u0430"}',
            'imo_number' => fake()->swiftBicNumber(),
            'technical_documentation' => fake()->boolean()
        ];
    }
}
