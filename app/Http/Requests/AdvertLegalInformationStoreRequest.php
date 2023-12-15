<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertLegalInformationStoreRequest extends FormRequest
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
            'advert_id' => 'required',
            /*'flag' => 'required|max:2',
            'exploitation_type' => 'required|max:2',
            'class_formula' => 'max:50',
            'wave_limit' => 'decimal:2|required|max:3.5',
            'ice_strengthening' => 'required|boolean',
            'type' => 'required|integer|max:20',
            'purpose' => 'required|string|max:50',
            'was_registered' => 'required|boolean',
            'register_valid_until' => 'date',
            'vessel_status' => 'requred|max:3',
            'project_number' => 'string|max:150',
            'building_number' => 'string|max:150',
            'building_year' => 'required|max:4',
            'building_country' => 'required|string|max:2',
            'port_address' => 'string',
            'vessel_location' => 'string',
            'imo_number' => 'imo_number'*/
        ];
    }
}
