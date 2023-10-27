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
        Schema::create('advert_techincal_information', function (Blueprint $table) {
            $table->id();
            $table->float('deadweight'); //дедвейт
            $table->float('max_speed_in_ballast'); //максимальная скорость в балласте
            $table->float('dock_weight'); //доковый вес
            $table->string('building_number'); //строительный номер
            $table->float('maximum_speed_when_loaded'); //максимальная скорость в грузу
            $table->float('full_displacement'); //водоизмещение полное
            $table->integer('passangers'); //пассажиров
            $table->float('carrying'); //грузоподъемность
            $table->smallInteger('distress_communication_systems'); //системы связи при бедствии
            $table->integer('total_peoples'); //общее количество людей на борту 
            $table->integer('crew_members'); //члены экипажа
            $table->integer('visitors'); //посетителей
            $table->float('gross_tonnage'); //валовая вместимость
            $table->float('registered_gross_tonnage'); //валовая вместимость (регистровых тонн)
            $table->integer('specialized_personnel'); //специализированный персонал
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advert_technical_information');
    }
};
