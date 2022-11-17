<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class DisciplineLevel extends Model
{
    use AsSource;

    protected $fillable = [
        'title',
        'digital_value',
    ];


}
