<?php

namespace App\Http\Requests\EducationalModule;

use Illuminate\Foundation\Http\FormRequest;

class CreateEducationalModuleRequest extends FormRequest
{
    public function rules(): array {
        return [
            'title'        => ['required', 'string'],
            'choice_limit' => ['required', 'integer'],
        ];
    }

    public function authorize(): bool {
        return true;
    }

    public function messages(): array {
        return [
            'required' => 'Обязательное поле',
            'string'   => 'Введены недопустимые символы',
        ];
    }
}
