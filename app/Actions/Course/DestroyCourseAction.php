<?php

namespace App\Actions\Course;

use App\Models\Course;
use Illuminate\Http\Request;

class DestroyCourseAction {
    public function run(Request $request): ?bool {
        return Course::findOrFail($request->input('id'))->forceDelete();
    }
}
