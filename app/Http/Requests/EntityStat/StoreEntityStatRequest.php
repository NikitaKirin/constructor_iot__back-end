<?php

namespace App\Http\Requests\EntityStat;

use App\Enums\EntityStatType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEntityStatRequest extends FormRequest
{
    public function rules(): array {
        return [
            'data'                                                    => ['required', 'array'],
            'data.*.*.created_at'                                     => ['required', 'date_format:Y-m-d H:i:s'],
            'data.educational_programs'                               => ['nullable', 'array'],
            'data.educational_programs.*.id'                          => ['required', 'exists:educational_programs,id'],
            'data.educational_programs.*.event_type'                  => ['required', Rule::in([EntityStatType::ClickInConstructor->value, EntityStatType::ClickToMore->value])],
            'data.course_assemblies'                                  => ['nullable', 'array'],
            'data.course_assemblies.*.id'                             => ['required', 'exists:course_assemblies,id'],
            'data.course_assemblies.*.event_type'                     => ['required', Rule::in([EntityStatType::ClickInConstructor->value, EntityStatType::ClickToMore->value])],
            'data.course_assemblies.*.educational_program_id'         => ['required', 'exists:educational_programs,id'],
            'data.professional_trajectories'                          => ['nullable', 'array'],
            'data.professional_trajectories.*.id'                     => ['required', 'exists:professional_trajectories,id'],
            'data.professional_trajectories.*.event_type'             => ['required', Rule::in([EntityStatType::ClickInConstructor->value, EntityStatType::ClickInList->value])],
            'data.professional_trajectories.*.educational_program_id' => ['required', 'exists:educational_programs,id'],
            'data.professions'                                        => ['nullable', 'array'],
            'data.professions.*.id'                                   => ['required', 'exists:professions,id'],
            'data.professions.*.event_type'                           => ['required', Rule::in([EntityStatType::ClickToMore->value])],
            'data.partner_courses'                                    => ['nullable', 'array'],
            'data.partner_courses.*.id'                               => ['required', 'exists:courses,id'],
            'data.partner_courses.*.event_type'                       => ['required', Rule::in([EntityStatType::ClickToMore->value])],
        ];
    }

    public function authorize() {
        return true;
    }
}
