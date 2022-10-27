<?php

namespace Database\Seeders;

use App\Models\AdmissionCommitteeContacts;
use Illuminate\Database\Seeder;

class AdmissionCommitteeContactsSeeder extends Seeder
{
    public function run() {
        AdmissionCommitteeContacts::create(
            [
                'address'      => 'Мира, 19',
                'phone_number' => '8-800-555-35-35',
                'email'        => 'rtf-priem@urfu.ru',
            ]
        );
    }
}
