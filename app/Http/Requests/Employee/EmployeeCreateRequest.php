<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'full_name'              => ['required', 'string'],
            'email'                  => ['email', 'nullable'],
            'phone_number'           => ['string', 'nullable'],
            'address'                => ['string', 'nullable'],
            'audience'               => ['string', 'nullable'],
            'additional_information' => ['string', 'nullable'],
            'position_id'            => ['required', 'exists:positions,id'],
        ];
    }

    public function messages() {
        return [
            'required' => 'Обязательное поле',
            'string'   => 'Введены недопустимые символы',
            'email'    => 'Введены недопустимые символы',
            'max'      => 'Превышено максимальное количество символов: :max',
            'exists'   => 'Указан несуществующий тип сотрудника',
        ];
    }
}
