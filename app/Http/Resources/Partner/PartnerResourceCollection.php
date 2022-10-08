<?php

namespace App\Http\Resources\Partner;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;

/** @see \App\Models\Partner */class PartnerResourceCollection extends ResourceCollection{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
        ];
    }
}
