<?php

namespace App\Http\Requests\AdmissionCommitteeContacts;

use Illuminate\Foundation\Http\FormRequest;

class CreateAdmissionCommitteeContactsRequest extends FormRequest
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
