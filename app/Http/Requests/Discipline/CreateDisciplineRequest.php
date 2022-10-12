<?php

namespace App\Http\Requests\Discipline;

use Illuminate\Foundation\Http\FormRequest;

class CreateDisciplineRequest extends FormRequest
{
    public function rules(): array {
        return [
            'title'       => ['required', 'string'],
            'description' => ['required', 'string'],
        ];
    }

    public function authorize(): bool {
        return true;
    }

    public function messages(): array {
        return [
            'required' => 'Поле обязательно для заполнения',
            'string'   => 'Недопустимые символы',
        ];
    }
}
