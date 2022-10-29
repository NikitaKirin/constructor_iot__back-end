<?php

namespace App\Http\Requests\SocialNetworksBlock;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSocialNetworksBlockRequest extends FormRequest
{
    public function rules(): array {
        return [
            'telegram' => ['required', 'url'],
            'vk'       => ['required', 'url'],
        ];
    }

    public function messages(): array {
        return [
            'required' => 'Обязательное поле',
            'url'      => 'Введите ссылку',
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
