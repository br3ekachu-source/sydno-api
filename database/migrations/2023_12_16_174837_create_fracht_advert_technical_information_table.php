<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\FrachtAdvert;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fracht_advert_technical_information', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FrachtAdvert::class);
            $table->float('overall_length'); //габаритная длина
            $table->float('overall_width'); //габаритная ширина
            $table->float('board_height'); //высота борта
            $table->float('maximum_freeboard'); //максимальный надводный борт
            $table->smallInteger('material'); //материал корпуса
            $table->float('deadweight'); //дедвейт
            $table->float('dock_weight'); //доковый вес
            $table->float('full_displacement'); //водоизмещение полное
            $table->float('gross_tonnage'); //валовая вместимость
            $table->smallInteger('num_engines'); //кол-во двигателей
            $table->float('power'); //мощность двигателей
            $table->float('maximum_speed_in_ballast'); //максимальная скорость в балласте
            $table->float('maximum_speed_when_loaded'); //максимальная скорость в грузу
            $table->boolean('cargo_tanks'); //наличие грузовых танков
            $table->float('total_capacity_cargo_tanks')->nullable(); //суммарная вместимость грузовых танков
            $table->boolean('second_bottom'); //второе дно
            $table->boolean('second_sides'); //вторые борта
            $table->float('carrying'); //грузоподъемность
            $table->boolean('superstructures'); //наличие надстроек
            $table->boolean('deckhouses'); //наличие рубок
            $table->boolean('liquid_tanks'); //наличие наливных танков
            $table->float('total_capacity_liquid_tanks')->nullable(); //суммарная вместимость наливных танков
            $table->boolean('passangers_avialable'); //наличие пассажировместимости
            $table->integer('num_passangers')->nullable(); //кол-во пассажиров
            $table->boolean('technical_documentation'); //наличие технической
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fracht_advert_technical_information');
    }
};
