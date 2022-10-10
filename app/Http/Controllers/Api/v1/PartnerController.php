<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Partner\PartnerResourceCollection;
use App\Models\Partner;

class PartnerController extends Controller
{
    /**
     * Получить список всех партнёров
     * Get the list of the partners
     */
    public function index() {
        return new PartnerResourceCollection(Partner::paginate(5));
    }
}
