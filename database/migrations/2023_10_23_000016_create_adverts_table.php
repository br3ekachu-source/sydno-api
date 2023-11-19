<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Address;

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
            $table->string('registration_number');
            $table->float('price'); //цена
            $table->foreignIdFor(Address::class)->nullable(); //адрес
            $table->smallInteger('state'); //статус объявления
            $table->json('images')->nullable(); //фотографии
            $table->string('header'); //заголовок
            $table->text('description'); //описание
            $table->string('phone_number');
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
