<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertTechnicalInformationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'advert_id' => 'required'
        ];
    }

    // $table->id();
    //         $table->foreignIdFor(Advert::class);
    //         $table->float('overall_length'); //габаритная длина
    //         $table->float('overall_width'); //габаритная ширина
    //         $table->float('board_height'); //высота борта
    //         $table->float('maximum_freeboard'); //максимальный надводный борт
    //         $table->smallInteger('material'); //материал корпуса
    //         $table->float('deadweight'); //дедвейт
    //         $table->float('dock_weight'); //доковый вес
    //         $table->float('full_displacement'); //водоизмещение полное
    //         $table->float('gross_tonnage'); //валовая вместимость
    //         $table->smallInteger('num_engines'); //кол-во двигателей
    //         $table->float('power'); //мощность двигателей
    //         $table->float('max_speed_in_ballast'); //максимальная скорость в балласте
    //         $table->float('maximum_speed_when_loaded'); //максимальная скорость в грузу
    //         $table->boolean('cargo_tanks'); //наличие грузовых танков
    //         $table->float('total_capacity_cargo_tanks')->nullable(); //суммарная вместимость грузовых танков
    //         $table->boolean('second_bottom'); //второе дно
    //         $table->boolean('second_sides'); //вторые борта
    //         $table->float('carrying'); //грузоподъемность
    //         $table->boolean('superstructures'); //наличие надстроек
    //         $table->boolean('deckhouses'); //наличие рубок
    //         $table->boolean('liquid_tanks'); //наличие наливных танков
    //         $table->float('total_capacity_liquid_tanks')->nullable(); //суммарная вместимость наливных танков
    //         $table->boolean('passangers_avialable'); //наличие пассажировместимости
    //         $table->integer('num_passangers')->nullable(); //кол-во пассажиров
    //         $table->boolean('technical_documentation'); //наличие технической
    //         $table->timestamps();
}
