<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Discipline extends Model
{
    use HasFactory, SoftDeletes, Userable, AsSource, Filterable;

    protected $fillable = [
        'title',
        'choice_limit',
        'is_spec',
    ];

    protected $allowedSorts = [
        'title',
        'choice_limit',
        'is_spec',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'title',
        'choice_limit',
        'is_spec',
    ];

    /**
     * Relationship - educational module to educational direction
     * @return BelongsToMany
     */
    public function educationalPrograms(): BelongsToMany {
        return $this->belongsToMany(EducationalProgram::class);
    }

    /**
     * Relationship - educational module to semesters
     * @return BelongsToMany
     */
    public function semesters(): BelongsToMany {
        return $this->belongsToMany(Semester::class, 'discipline_semester');
    }

    /**
     * @return BelongsToMany
     */
    public function courseAssemblies(): BelongsToMany {
        return $this->belongsToMany(CourseAssembly::class, 'course_assembly_discipline');
    }
}
