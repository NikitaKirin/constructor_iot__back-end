<?php

namespace App\Http\Requests\ProfessionalTrajectory;

use Illuminate\Foundation\Http\FormRequest;

class ShowProfessionalTrajectoryRequest extends FormRequest
{
    public function rules(): array {
        return [
            'loadCourseAssembliesCount' => ['nullable', 'boolean'],
            'loadProfessions'           => ['nullable', 'boolean'],
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
    protected function prepareForValidation() {
        $this->merge([
            'loadCourseAssembliesCount' => $this->toBoolean($this->loadCourseAssembliesCount),
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
