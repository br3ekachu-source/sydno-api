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
        Schema::create('advert_legal_information', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('exploitation_type'); //тип эксплуатации
            $table->boolean('self_propelled'); //самоходность
            $table->boolean('valid_documents'); //действующие документы
            $table->boolean('was_registered'); //находилось ли на учете
            $table->boolean('was_registered_by_5_years'); //находилос ли на учете за последнии 5 лет
            $table->boolean('full_size'); //полноразмерное/маломерное
            $table->smallInteger('vessel_status'); //статус судна
            $table->smallInteger('object_status'); //статус объекта
            $table->smallInteger('type'); //тип судна
            $table->smallInteger('purpose'); //назначение судна
            $table->year('building_year'); //год постройки
            $table->foreignIdFor(Address::class, 'building_address'); //адрес постройки
            $table->string('call_name'); //позвыной
            $table->string('project_author'); //автор проекта
            $table->string('project_number'); //номер проекта 
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
