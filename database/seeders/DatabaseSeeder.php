<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Advert;
use App\Models\AdvertLegalInformation;
use App\Models\AdvertTechnicalInformation;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $advertsCount = 100;
        User::factory(10)->create();
        Advert::factory($advertsCount)->create();
        AdvertLegalInformation::factory($advertsCount)->create();
        AdvertTechnicalInformation::factory($advertsCount)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
