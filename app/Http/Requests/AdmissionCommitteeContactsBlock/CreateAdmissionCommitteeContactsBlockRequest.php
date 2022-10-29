<?php

namespace App\Http\Requests\AdmissionCommitteeContactsBlock;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdmissionCommitteeContactsBlockRequest extends FormRequest
{
    public function rules(): array {
        return [
            'address'      => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'email'        => ['required', 'email'],
        ];
    }

    public function authorize(): bool {
        return true;
    }

    public function messages(): array {
        return [
            'required' => __('Обязательное поле'),
            'email'    => __('Некорректный email'),
        ];
    }
}
