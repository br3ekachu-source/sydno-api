<?php

namespace Database\Factories;

use App\Http\Services\AdvertState;
use App\Http\Services\Consts;
use App\Models\Advert;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

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
        $links = [
            'https://i.imgur.com/DcoyVn3.png',
            'https://i.imgur.com/QTKQk8a.png',
            'https://i.imgur.com/vnX3hnH.png',
            'https://i.imgur.com/wRts6gd.png'
        ];
        //$photo = [];
        // $url = "https://i.imgur.com/DcoyVn3.png";
        // $contents = file_get_contents($url);
        // $name = 'advert_images/'.substr($url, strrpos($url, '/') + 1);
        // Storage::put($name, $contents);
        return [
            'user_id' => fake()->numberBetween(1, 10),
            'registration_number' => fake()->swiftBicNumber(),
            'price' => fake()->numberBetween(1000000, 999999999),
            'state' => AdvertState::Active,
            'header' => fake()->sentence(3, true),
            'description' => fake()->text(),
            'phone_number' => fake()->phoneNumber(),
            'views' => fake()->numberBetween(0, 5000),
            //'images' => $path
        ];
    }
}
