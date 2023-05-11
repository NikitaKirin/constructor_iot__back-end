<?php

namespace App\Http\Requests\ProfessionalTrajectory;

use Illuminate\Foundation\Http\FormRequest;

class IndexProfessionalTrajectoryRequest extends FormRequest
{
    public function rules(): array {
        return [
            'educational_program_id' => ['nullable', 'exists:educational_programs,id'],
            'loadProfessions'        => ['nullable', 'boolean'],
        ];
    }

    public function authorize(): bool {
        return true;
    }

    /**
     * Prepare inputs for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'loadProfessions' => $this->toBoolean($this->loadProfessions),
        ]);
    }

    /**
     * Convert to boolean
     *
     * @param $booleable
     * @return boolean
     */
    private function toBoolean($booleable): ?bool {
        return filter_var($booleable, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
