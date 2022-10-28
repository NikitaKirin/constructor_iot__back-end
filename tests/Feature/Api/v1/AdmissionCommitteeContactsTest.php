<?php

namespace Tests\Feature\Api\v1;

use App\Models\AdmissionCommitteeContacts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AdmissionCommitteeContactsTest extends TestCase
{
    use RefreshDatabase;

    public function testAdmissionCommitteeContactsIndex() {

        $admissionCommitteeContacts = AdmissionCommitteeContacts::factory(1)
                                                                ->create()->first();

        $response = $this->get(route('admissionCommitteeContacts.index'));

        $response->assertOk();

        $response->assertJson(fn( AssertableJson $json ) => $json->has('admission_committee_contacts',
            fn( $json ) => $json->where('id', $admissionCommitteeContacts->id)
                                ->where('address',
                                    $admissionCommitteeContacts->address)
                                ->where('phone_number',
                                    $admissionCommitteeContacts->phone_number)
                                ->where('email',
                                    $admissionCommitteeContacts->email)
        ));

    }
}
