<?php

namespace App\Http\Resources\Profession;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Profession */
class ProfessionResourceCollection extends ResourceCollection
{
    public static $wrap = 'professions';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request) {
        return [
            'professions' => $this->collection,
        ];
    }
}
