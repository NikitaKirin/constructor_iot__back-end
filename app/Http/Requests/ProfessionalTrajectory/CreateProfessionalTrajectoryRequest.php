<?php

namespace App\Http\Requests\ProfessionalTrajectory;

use Illuminate\Foundation\Http\FormRequest;

class CreateProfessionalTrajectoryRequest extends FormRequest
{
    public function rules(): array {
        return [
            'title'       => ['required', 'string'],
            'description' => ['required', 'string'],
            'color'       => ['required'],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
