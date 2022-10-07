<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest
{
    public function rules(): array {
        return [
            'author'                 => ['required', 'string'],
            'text'                   => ['required', 'string'],
            'additional_information' => ['required', 'string'],
        ];
    }

    public function authorize(): bool {
        return true;
    }

    public function messages() {
        return [
            'required' => 'Обязательное поле',
            'string'   => 'Введены недопустимые символы',
        ];
    }
}
