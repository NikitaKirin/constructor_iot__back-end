<?php

namespace App\Http\Resources\EducationalProgram;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\EducationalProgram */
class EducationalProgramResource extends JsonResource
{
    public static $wrap = 'educational_program';

    /**
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'educational_direction' => $this->educational_direction,
            'passing_scores' => $this->passing_scores,
            'training_period' => $this->training_period,
            'budget_places' => $this->budget_places,
            'page_link' => $this->page_link,
        ];
    }
}
