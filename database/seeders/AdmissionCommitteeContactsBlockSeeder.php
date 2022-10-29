<?php

namespace Database\Seeders;

use App\Models\AdmissionCommitteeContactsBlock;
use App\Models\Institute;
use Illuminate\Database\Seeder;

class AdmissionCommitteeContactsBlockSeeder extends Seeder
{
    public function run() {
        AdmissionCommitteeContactsBlock::create(
            [
                'address'      => 'Мира, 19',
                'phone_number' => '8-800-555-35-35',
                'email'        => 'rtf-priem@urfu.ru',
                'institute_id' => Institute::where('abbreviation', 'ILIKE', 'ИРИТ-РТФ')->get()
                                           ->first()->id,
            ]
        );
    }
}
