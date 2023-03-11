<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    use Userable;
    protected $table = 'frequently_asked_questions';

    protected $fillable = [
        'question',
        'answer',
    ];
}
