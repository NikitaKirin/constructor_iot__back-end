<?php

namespace App\Http\Resources\AdmissionCommitteeContactsBlock;

use App\Models\AdmissionCommitteeContactsBlock;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin AdmissionCommitteeContactsBlock */
class AdmissionCommitteeContactsBlockResource extends JsonResource
{
    public static $wrap = 'admission_committee_contacts_block';

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
