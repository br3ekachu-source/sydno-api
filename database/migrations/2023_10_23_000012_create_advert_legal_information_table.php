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
        Schema::create('advert_legal_information', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Advert::class);
            $table->string('name'); //имя судна
            $table->char('flag', 2); //флаг
            $table->smallInteger('exploitation_type'); //тип эксплуатации
            $table->string('class_formula'); //формула класса
            $table->float('wave_limit'); //ограничение по высоте волны
            $table->smallInteger('type'); //тип судна
            $table->string('purpose'); //назначение судна
            $table->boolean('was_registered'); //находилось ли на учете
            $table->date('register_valid_until')->nullable(); //учед действует до (месяц, год)
            $table->smallInteger('vessel_status'); //статус судна
            $table->string('project_number')->nullable(); //номер проекта
            $table->string('building_number')->nullable(); //строительный номер
            $table->year('building_year'); //год постройки
            $table->string('classification_society')->nullable();
            $table->string('building_place')->nullable(); //место постройки
            //$table->char('building_country', 2); //страна постройки
            $table->json('port_address')->nullable(); //порт приписки (точность до города)
            $table->json('vessel_location')->nullable(); //местонахождение судна
            $table->string('imo_number')->nullable(); //номер imo
            $table->boolean('technical_documentation'); //наличие технической документации
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
