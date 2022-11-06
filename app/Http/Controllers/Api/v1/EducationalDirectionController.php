<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EducationalDirection\EducationalDirectionResourceCollection;
use App\Models\EducationalDirection;

class EducationalDirectionController extends Controller
{
    public function index() {
        return new EducationalDirectionResourceCollection(EducationalDirection::orderBy('title')->paginate(4));
    }
}
