<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Advert;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdvertTechnicalInformation>
 */
class AdvertTechnicalInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ids = Advert::all()->pluck('id');
        $cargoTanks = fake()->boolean();
        $liquidTanks = fake()->boolean();
        $passangersAvialable = fake()->boolean();
        return [
            'advert_id' => fake()->unique()->randomElement($ids),
            'overall_length' => fake()->randomFloat(1, 2, 50),
            'overall_width' => fake()->randomFloat(1, 2, 30),
            'board_height' => fake()->randomFloat(1, 0.5, 20),
            'draft_in_cargo' => fake()->randomFloat(1, 0.5, 10),
            'material' => fake()->numberBetween(0, 4),
            'deadweight' => fake()->randomFloat(1, 100, 10000),
            'dock_weight' => fake()->randomFloat(1, 100, 30000),
            'full_displacement' => fake()->randomFloat(1, 100, 30000),
            'gross_tonnage' => fake()->randomFloat(1, 100, 30000),
            'num_engines' => fake()->numberBetween(0, 8),
            'num_additional_engines' => fake()->numberBetween(0, 8),
            'power' => fake()->randomFloat(1, 100, 30000),
            'maximum_speed' => fake()->randomFloat(1, 0, 100),
            'cargo_tanks' => $cargoTanks,
            'total_capacity_cargo_tanks' => $cargoTanks ? fake()->randomFloat(1, 100, 30000) : null,
            'second_bottom' => fake()->boolean(),
            'second_sides' => fake()->boolean(),
            'carrying' => fake()->randomFloat(1, 100, 10000),
            //'superstructures' => fake()->boolean(),
            'liquid_tanks' => $liquidTanks,
            'total_capacity_liquid_tanks' => $liquidTanks ? fake()->randomFloat(1, 100, 30000) : null,
            'passangers_avialable' => $passangersAvialable,
            'num_passangers' => $passangersAvialable ? fake()->numberBetween(0, 200) : null
        ];
    }
}
