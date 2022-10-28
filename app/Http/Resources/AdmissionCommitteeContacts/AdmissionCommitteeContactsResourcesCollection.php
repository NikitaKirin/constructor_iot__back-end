<?php

namespace App\Http\Resources\AdmissionCommitteeContacts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\AdmissionCommitteeContacts */
class AdmissionCommitteeContactsResourcesCollection extends ResourceCollection
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'data' => $this->collection,
        ];
    }
}
