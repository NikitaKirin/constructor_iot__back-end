<?php

namespace Database\Seeders;

use App\Models\Institute;
use App\Models\SocialNetworksBlock;
use Illuminate\Database\Seeder;

class SocialNetworksBlockSeeder extends Seeder
{
    public function run() {
        $socialNetworksBlock = new SocialNetworksBlock();
        $socialNetworksBlock->institute_id = Institute::where('abbreviation', 'ILIKE', 'ИРИТ-РТФ')
                                                      ->first()->id;
        $socialNetworksBlock->save();
    }
}
