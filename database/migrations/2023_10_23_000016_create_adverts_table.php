<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('adverts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class); //пользователь
            $table->smallInteger('advert_type'); //тип объявления
            $table->string('registration_number');
            $table->integer('price')->nullable(); //цена
            $table->smallInteger('state'); //статус объявления
            $table->json('images')->nullable(); //фотографии
            $table->string('header'); //заголовок
            $table->text('description'); //описание
            $table->string('phone_number'); //номер телефона
            $table->smallInteger('fracht_type')->nullable(); //тип аренды
            $table->smallInteger('fracht_price_type')->nullable(); //тип промежутка цены аренды
            $table->timestamps(); //дата создания объявления
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adverts');
    }
};
