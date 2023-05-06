<?php

namespace App\Models;

use App\Traits\Statisiticable;
use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class CourseAssembly extends Model
{
    use HasFactory, SoftDeletes, AsSource, Userable, Filterable, Statisiticable;

    protected $fillable = [
        'title',
        'description',
    ];

    protected $allowedSorts = [
        'title',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'title',
    ];

    /**
     * @return BelongsTo
     */
    public function discipline(): BelongsTo {
        return $this->belongsTo(Discipline::class);
    }

    /**
     * @return BelongsToMany
     */
    public function professionalTrajectories(): belongsToMany {
        return $this->belongsToMany(ProfessionalTrajectory::class, 'course_assembly_professional_trajectory')
                    ->withPivot('course_assembly_level_digital_value');
    }

    /**
     * @return BelongsToMany
     */
    public function courses(): BelongsToMany {
        return $this->belongsToMany(Course::class, 'course_assembly_course');
    }

    public function getWithEducationalProgramAttribute() {
        $educationalPrograms = get_educational_programs_ciphers_string($this->discipline->educationalPrograms()->get()->toArray());
        return $educationalPrograms . " | " . $this->discipline->title . " | " . $this->attributes['title'];
    }

}
