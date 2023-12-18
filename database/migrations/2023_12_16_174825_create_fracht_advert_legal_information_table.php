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
        Schema::create('fracht_advert_legal_information', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(FrachtAdvert::class);
            $table->char('flag', 2); //флаг
            $table->smallInteger('exploitation_type'); //тип эксплуатации
            $table->string('class_formula'); //формула класса
            $table->float('wave_limit'); //ограничение по высоте волны
            $table->boolean('ice_strengthening'); //ледовое усиление
            $table->smallInteger('type'); //тип судна
            $table->string('purpose'); //назначение судна
            $table->boolean('was_registered'); //находилось ли на учете
            $table->date('register_valid_until'); //учед действует до
            $table->smallInteger('vessel_status'); //статус судна
            $table->string('project_number'); //номер проекта
            $table->string('building_number'); //строительный номер
            $table->year('building_year'); //год постройки
            $table->char('building_country', 2); //страна постройки
            $table->json('port_address')->nullable(); //порт приписки
            $table->json('vessel_location')->nullable(); //местонахождение судна
            $table->string('imo_number')->nullable(); //номер imo
            $table->timestamps();      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fracht_advert_legal_information');
    }
};
