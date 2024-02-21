<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'phone' => 'required|string',
            'mark' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|string',
            'mileage' => 'required|string',
            'capacity' => 'required|string',
            'engine_type' => 'required|string',
            'transmission_type' => 'required|string',
            'drive_unit' => 'required|string',
            'color' => 'required|string',
            'arrested' => 'required|string',
            'pledged' => 'required|string',
            'in_kz' => 'required|string',
            'crashed' => 'required|string',
            'right_hand' => 'required|string',
            'vin' => 'string',
            'comment' => 'string',
//            'images' => 'required',
        ];
    }
}
