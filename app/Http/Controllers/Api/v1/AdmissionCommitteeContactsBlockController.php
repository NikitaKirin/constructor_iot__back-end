<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdmissionCommitteeContactsBlock\AdmissionCommitteeContactsBlockResource;
use App\Models\AdmissionCommitteeContactsBlock;

class AdmissionCommitteeContactsBlockController extends Controller
{
    public function index() {
        return new AdmissionCommitteeContactsBlockResource(AdmissionCommitteeContactsBlock::first());
    }
}
