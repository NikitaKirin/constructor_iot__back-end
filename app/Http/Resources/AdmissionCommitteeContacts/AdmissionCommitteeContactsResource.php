<?php

namespace App\Http\Resources\AdmissionCommitteeContacts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\AdmissionCommitteeContacts */
class AdmissionCommitteeContactsResource extends JsonResource
{
    public static $wrap = 'admission_committee_contacts';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray( $request ) {
        return [
            'id'           => $this->id,
            'address'      => $this->address,
            'phone_number' => $this->phone_number,
            'email'        => $this->email,
        ];
    }
}
