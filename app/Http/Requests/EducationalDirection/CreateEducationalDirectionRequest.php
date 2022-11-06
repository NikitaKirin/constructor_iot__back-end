<?php

namespace App\Http\Requests\EducationalDirection;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateEducationalDirectionRequest extends FormRequest
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
        $educationalDirectionId = $this->query->get('educationalDirection');
        return [
            'title'          => [
                'required',
                'string',
                Rule::unique('educational_directions')->where(fn( $query ) => $query->where
                ('id', '<>', $educationalDirectionId)),
            ],
            'cipher'         => [
                'required',
                'string',
                Rule::unique('educational_directions')->where(fn( $query ) => $query->where
                ('id', '<>', $educationalDirectionId)),
                'max: 15',
            ],
            'passing_scores' => [
                'nullable',
                'array',
            ],

            'training_period' => ['required', 'string'],

            'budget_places' => ['required', 'integer', 'min:0'],

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
