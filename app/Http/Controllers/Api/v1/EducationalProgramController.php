<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EducationalProgram\EducationalProgramResourceCollection;
use App\Models\EducationalProgram;

class EducationalProgramController extends Controller
{
    public function index() {
        return new EducationalProgramResourceCollection(EducationalProgram::orderBy('title')->has('disciplines')->paginate(4));
    }
}
