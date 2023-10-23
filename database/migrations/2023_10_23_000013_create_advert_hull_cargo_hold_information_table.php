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
        Schema::create('advert_hull_cargo_hold_information', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(AdvertHullInformation::class);
            $table->float('volume'); //объем
            $table->float('hatch_length'); //длина люка
            $table->float('hatch_width'); //ширина люка
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advert_hull_cargo_hold_information');
    }
};
