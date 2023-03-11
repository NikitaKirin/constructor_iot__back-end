<?php

namespace App\Actions\FAQ;

use App\Actions\FAQ\DTO\UpdateFAQData;
use App\Models\FAQ;
use Illuminate\Support\Facades\Auth;

class UpdateFAQAction
{
    public function run(FAQ $faq, UpdateFAQData $data): bool {
        $faq->user()->associate(Auth::user())->save();
        return $faq->update([
            'question' => $data->question,
            'answer'   => $data->answer,
        ]);
    }
}
