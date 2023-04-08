<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class CourseAssemblyLevel extends Model
{
    use AsSource;

    protected $fillable = [
        'title',
        'digital_value',
    ];


}
