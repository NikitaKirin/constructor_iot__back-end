<?php

namespace App\Http\Requests\Profession;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateProfessionRequest extends FormRequest
{
    public function rules(): array {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'headHunter_title' => ['required', 'string']
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
