<?php

namespace App\Http\Requests\ProfessionalTrajectory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateProfessionalTrajectoryRequest extends FormRequest
{
    public function rules(): array {
        $professionalTrajectoryId = $this->request->get('id');
        return [
            'title'       => ['required', 'string'],
            'description' => ['required', 'string'],
            'color'       => [
                'required',
                Rule::unique('professional_trajectories')->where(fn( $query ) => $query->where
                ('id', '<>', $professionalTrajectoryId)),
            ],
        ];
    }

    public function authorize(): bool {
        return true;
    }
}
