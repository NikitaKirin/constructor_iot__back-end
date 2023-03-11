<?php

namespace App\Actions\FAQ;

use App\Models\FAQ;
use Illuminate\Http\Request;

class DestroyFAQAction
{

    public function run(Request $request): bool {
        return FAQ::findOrFail($request->input('id'))->forceDelete();
    }
}
