<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertStoreRequest extends FormRequest
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
            'registration_number' => 'required',
            /*'price' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,svg:max:2048',
            'header' => 'required|max:255',
            'decription' => 'required|max:2000',
            'phone_number' => 'required'*/
        ];
    }

    public function messages(): array
    {
        return [
            /*'price.required' => 'Необходимо указать цену',
            'header.required' => 'Необходимо указать заголовок'*/
        ];
    }
}
