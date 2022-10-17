<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;

class CreateCourseRequest extends FormRequest
{
    public function rules(): array {
        return [
            'title'       => ['required', 'string'],
            'description' => ['required', 'string'],
            'limit'       => ['required', 'numeric'],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
