<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class FAQ extends Model
{
    use Userable, AsSource, Filterable, HasFactory;

    protected $table = 'frequently_asked_questions';

    protected $fillable = [
        'question',
        'answer',
    ];

    protected $allowedSorts = [
        'updated_at',
    ];

    protected $allowedFilters = [
        'question',
    ];
}
