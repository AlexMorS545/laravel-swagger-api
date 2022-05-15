<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'type' => 'required|min:3',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute обязательное поле',
            'name.min' => 'Минимальная длина 3 символа',
            'type.required' => ':attribute обязательное поле',
            'type.min' => 'Минимальная длина 3 символа',
        ];
    }
}
