<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Address;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('advert_legal_information', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('flag'); //флаг
            $table->smallInteger('class_formula_part_1'); //левая чать формулы класса
            $table->smallInteger('class_formula_part_2'); //правая часть формулы класса
            $table->smallInteger('exploitation_type'); //тип эксплуатации
            $table->smallInteger('type'); //тип судна
            $table->string('purpose'); //назначение судна
            $table->boolean('was_registered'); //находилось ли на учете
            $table->date('register_valid_until'); //учед действует до
            $table->smallInteger('vessel_status'); //статус судна
            $table->string('project_number'); //номер проекта
            $table->string('building_number'); //строительный номер
            $table->year('building_year'); //год постройки
            $table->foreignIdFor(Address::class, 'building_address'); //адрес постройки
            $table->timestamps();           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advert_legal_information');
    }
};
