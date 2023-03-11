<?php

namespace App\Actions\FAQ;

use App\Actions\FAQ\DTO\CreateFAQData;
use App\Models\FAQ;
use Illuminate\Support\Facades\Auth;

class CreateFAQAction
{
    public function run(CreateFAQData $data): FAQ {
        $faq = FAQ::create([
            'question' => $data->question,
            'answer'   => $data->answer,
        ]);
        $faq->user()->associate(Auth::user())->save();
        return $faq;
    }
}
