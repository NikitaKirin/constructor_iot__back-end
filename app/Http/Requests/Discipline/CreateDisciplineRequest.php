<?php

namespace App\Http\Requests\Discipline;

use Illuminate\Foundation\Http\FormRequest;

class CreateDisciplineRequest extends FormRequest
{
    public function rules(): array {
        return [
            'title'        => ['required', 'string'],
            'choice_limit' => ['required', 'integer'],
            'is_spec'      => ['required', 'boolean'],
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
