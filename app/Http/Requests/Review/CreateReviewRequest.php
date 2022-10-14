<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class CreateReviewRequest extends FormRequest
{
    public function rules(): array {
        return [
            'author'                => ['required', 'string'],
            'text'                  => ['required', 'string'],
            'educational_direction' => ['required', 'string'],
            'year_of_issue'         => ['nullable', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'course'                => ['nullable', 'between:1,5'],
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
