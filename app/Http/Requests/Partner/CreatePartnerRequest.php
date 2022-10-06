<?php

namespace App\Http\Requests\Partner;

use Illuminate\Foundation\Http\FormRequest;

class CreatePartnerRequest extends FormRequest
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

    public function messages() {
        return [
            'required' => 'Обязательное поле',
        ];
    }
}
