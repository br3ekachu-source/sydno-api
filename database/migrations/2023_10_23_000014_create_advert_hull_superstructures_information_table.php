<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('advert_hull_superstructures_information', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AdvertHullInformation::class);
            $table->integer('tier_number'); //номер яруса
            $table->smallInteger('material'); //материал
            $table->integer('location_rib_at'); //расположение между шпангоутами от
            $table->integer('location_rib_to'); //расположение между шпангоутами до
            $table->boolean('participates_in_the_general_bending'); //учавствует в общем изгибе
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advert_hull_superstructures_information');
    }
};
