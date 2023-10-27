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
        Schema::create('advert_hull_information', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('material'); //материал корпуса
            $table->smallInteger('dialing_system'); //система набора
            $table->smallInteger('preparation_method'); //метод изготовления
            $table->integer('longitudinal_bulkheads'); //продольные переборки
            $table->integer('transverse_bulkheads'); //поперечные переборки
            $table->boolean('second_bottom'); //второе дно
            $table->float('overall_length'); //габаритная длина
            $table->float('board_height'); //высота борта
            $table->float('overall_width'); //габаритная ширина
            $table->float('power'); //мощность
            $table->int('num_engines'); //кол-во двигателей
            $table->json('generators'); //кол-во генераторов
            $table->float('height_from_main_plane'); //высота от основной плоскости
            $table->float('maximum_freeboard'); //максимальный надводный борт
            $table->boolean('inner_sides'); //внутренние борта
            $table->boolean('availability_cargo_holds'); //наличие грузовых трюмов
            $table->boolean('availability_superstructures'); //наличие надстроек или трюмов
            $table->boolean('availability_tanks'); //наличие танков
            $table->float('total_capacity_cargo_tanks'); //суммарная вместимость грузовых танков
            $table->float('total_capacity_water_tanks'); //суммарная вместимость танков воды
            $table->float('total_capacity_fuel_tanks'); //суммарная вместимость топливных танков
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advert_hull_information');
    }
};
