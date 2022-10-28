<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdmissionCommitteeContacts\AdmissionCommitteeContactsResource;
use App\Models\AdmissionCommitteeContacts;

class AdmissionCommitteeContactsController extends Controller
{
    public function index() {
        return new AdmissionCommitteeContactsResource(AdmissionCommitteeContacts::first());
    }
}
