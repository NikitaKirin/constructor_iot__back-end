<?php

namespace App\Http\Resources\AdmissionCommitteeContactsBlock;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\AdmissionCommitteeContactsBlock */
class AdmissionCommitteeContactsBlockResourcesCollection extends ResourceCollection
{
    public static $wrap = "admission_committee_contacts_block";

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'admission_committee_contacts_block' => $this->collection,
        ];
    }
}
