<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        return $this->belongsToMany(EducationalProgram::class, 'discipline_educational_program');
    }

    /**
     * Relationship - educational module to semesters
     * @return BelongsToMany
     */
    public function semesters(): BelongsToMany {
        return $this->belongsToMany(Semester::class, 'discipline_semester');
    }

    /**
     * @return HasMany
     */
    public function courseAssemblies(): HasMany {
        return $this->hasMany(CourseAssembly::class);
    }

    public function getWithEducationalProgramAttribute() {
        $educationalPrograms = get_educational_programs_ciphers_string($this->educationalPrograms()->get()->toArray());
        return $educationalPrograms . ": " . $this->attributes['title'];
    }
}
