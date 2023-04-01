<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCourseRequest extends FormRequest
{
    public function rules(): array {
        return [
            'title'           => ['required', 'string'],
            'description'     => ['required', 'string'],
            'seat_limit'      => ['required', 'numeric'],
            'realization_id'  => ['required', Rule::exists('realizations', 'id')],
            'video_id'        => ['array'],
            'presentation_id' => ['array'],
            'documents'       => ['array'],
            'discipline_id'  => ['nullable', Rule::exists('disciplines', 'id')],
            'partner_id'     => ['nullable', Rule::exists('partners', 'id')],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
