<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Advert;
use App\Models\AdvertLegalInformation;
use App\Models\AdvertTechnicalInformation;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        DB::table('adverts')->update(['images' => '["advert_images\/R3Op9YuK7xG4wdZLbqtoqNVejllu83a1PGIXU62o.jpg","advert_images\/1shLCsbpsDCLLCDNmNBg60gcwYX6zNDvoCENsS1W.jpg","advert_images\/6pk4s07P8m44od2AApgQgiXmlWgJXYve8CP9Sr8m.jpg"]']);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
