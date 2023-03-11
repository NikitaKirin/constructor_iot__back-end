<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FAQ\FAQResourceCollection;
use App\Models\FAQ;

class FAQController extends Controller
{
    public function index() {
        return new FAQResourceCollection(FAQ::all());
    }
}
