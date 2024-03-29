<?php

namespace App\Http\Requests\Profession;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrUpdateProfessionRequest extends FormRequest
{
    public function rules(): array {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'headhunter_search_text' => ['required', 'string'],
            'photo_id' => ['required'],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
