<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Advert;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('advert_technical_information', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Advert::class);
            $table->float('overall_length'); //габаритная длина
            $table->float('overall_width'); //габаритная ширина
            $table->float('board_height'); //высота борта
            //$table->float('maximum_freeboard'); //максимальный надводный борт
            $table->float('draft_in_cargo'); //осадка в грузу (не боьльше высоты борта)
            $table->smallInteger('material'); //материал корпуса
            $table->float('deadweight')->nullable(); //дедвейт
            $table->float('dock_weight')->nullable(); //доковый вес
            $table->float('full_displacement')->nullable(); //водоизмещение полное
            $table->float('gross_tonnage')->nullable(); //валовая вместимость
            $table->smallInteger('num_engines'); //кол-во двигателей
            $table->smallInteger('num_additional_engines'); //кол-во вспомогательных двигаßтелей
            $table->float('power'); //мощность двигателей
            $table->float('maximum_speed')->nullable(); //максимальная скорость в грузу
            $table->boolean('cargo_tanks')->nullable(); //наличие грузовых танков
            $table->float('total_capacity_cargo_tanks')->nullable(); //суммарная вместимость грузовых танков
            $table->boolean('second_bottom'); //второе дно
            $table->boolean('second_sides'); //вторые борта
            $table->float('carrying'); //грузоподъемность
            //$table->boolean('superstructures'); //наличие надстроек
            $table->boolean('liquid_tanks'); //наличие наливных танков
            $table->float('total_capacity_liquid_tanks')->nullable(); //суммарная вместимость наливных танков
            $table->boolean('passangers_avialable'); //наличие пассажировместимости
            $table->integer('num_passangers')->nullable(); //кол-во пассажиров
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
