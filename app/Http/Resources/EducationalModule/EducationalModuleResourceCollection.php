<?php

namespace App\Http\Resources\EducationalModule;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\EducationalModule */
class EducationalModuleResourceCollection extends ResourceCollection
{
    public static $wrap = 'educational_modules';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'educational_modules' => $this->collection,
        ];
    }
}
