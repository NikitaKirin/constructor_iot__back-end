<?php

namespace Tests\Feature\Api\v1;

use App\Models\AdmissionCommitteeContactsBlock;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AdmissionCommitteeContactsTest extends TestCase
{
    use RefreshDatabase;

    public function testAdmissionCommitteeContactsIndex() {

        $admissionCommitteeContactsBlock = AdmissionCommitteeContactsBlock::all()
                                                                          ->first();

        $response = $this->get(route('admissionCommitteeContactsBlock.index'));

        $response->assertOk();

        $response->assertJson(fn( AssertableJson $json ) => $json->has('admission_committee_contacts_block',
            fn( $json ) => $json->where('id', $admissionCommitteeContactsBlock->id)
                                ->where('address',
                                    $admissionCommitteeContactsBlock->address)
                                ->where('phone_number',
                                    $admissionCommitteeContactsBlock->phone_number)
                                ->where('email',
                                    $admissionCommitteeContactsBlock->email)
                                ->where('institute', $admissionCommitteeContactsBlock->institute->abbreviation)
        ));

    }
}
