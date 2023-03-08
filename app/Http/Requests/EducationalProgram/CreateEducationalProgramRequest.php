<?php

namespace App\Http\Requests\EducationalProgram;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateEducationalProgramRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    public function rules() {
        $educationalProgram = $this->query->get('educationalProgram');
        return [
            'title' => [
                'required',
                'string',
                Rule::unique('educational_programs')->ignore($educationalProgram),
            ],

            'educational_direction' => ['required', 'string'],

            'passing_scores' => ['nullable', 'array'],

            'training_period' => ['required', 'string'],

            'budget_places' => ['required', 'integer', 'min:0'],

            'page_link' => ['required', 'url'],

        ];
    }

    public function messages() {
        return [
            'required' => 'Это поле обязательно для заполнения',
            'string'   => 'Поле должно быть строкой',
            'max'      => 'Максимальное количество значений: :max',
            'unique'   => 'Данное значение уже существует',
        ];
    }
}
