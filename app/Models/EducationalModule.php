<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EducationalModule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'choice_limit',
    ];

    /**
     * Relationship - educational module to user
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship - educational module to educational direction
     * @return BelongsToMany
     */
    public function educationalDirections(): BelongsToMany {
        return $this->belongsToMany(EducationalDirection::class);
    }

    /**
     * Relationship - educational module to semesters
     * @return BelongsToMany
     */
    public function semesters(): BelongsToMany {
        return $this->belongsToMany(Semester::class, 'semester_educational_module');
    }

    /**
     * Relationship - educational module to disciplines
     * @return BelongsToMany
     */
    public function disciplines(  ): BelongsToMany {
        return $this->belongsToMany(Discipline::class, 'educational_module_discipline');
    }
}
