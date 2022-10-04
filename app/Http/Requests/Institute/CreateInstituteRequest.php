<?php

namespace App\Http\Requests\Institute;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateInstituteRequest extends FormRequest
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
        $instituteId = $this->query->get('institute');
        return [
            'title'        => [
                'required',
                'string',
                Rule::unique('institutes')->where(fn( $query ) => $query->where
                ('id', '<>', $instituteId)),
            ],
            'abbreviation' => [
                'required',
                'string',
                Rule::unique('institutes')->where(fn( $query ) => $query->where
                ('id', '<>', $instituteId)),
                'max: 15',
            ],
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

    /*public function prepareForValidation() {
        if ( $this->request->has('institute') ) {
            $institute = $this->request->all('institute');
            $this->merge([
                'title'        => $institute['title'],
                'abbreviation' => $institute['abbreviation'],
            ]);
        }
    }*/
}
