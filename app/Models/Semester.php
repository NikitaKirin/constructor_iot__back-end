<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class Semester extends Model
{
    use HasFactory, SoftDeletes, AsSource;

    protected $fillable = [
        'text_representation',
        'numeric_representation',
    ];

    /**
     * Relationship - semester to user
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class)->withDefault(['name' => __('Не определено')]);
    }

    /**
     * Relationship - semester to educational modules
     * @return BelongsToMany
     */
    public function educationalModules(): BelongsToMany {
        return $this->belongsToMany(EducationalModule::class, 'semester_educational_module');
    }
}
