<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class CourseAssembly extends Model
{
    use HasFactory, SoftDeletes, AsSource, Userable, Filterable;

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
     * @return BelongsToMany
     */
    public function disciplines(): BelongsToMany {
        return $this->belongsToMany(Discipline::class, 'course_assembly_discipline');
    }

    /**
     * @return BelongsToMany
     */
    public function professionalTrajectories(): belongsToMany {
        return $this->belongsToMany(ProfessionalTrajectory::class, 'course_assembly_professional_trajectory')
                    ->withPivot('course_assembly_level_digital_value');
    }

    /**
     * @return HasMany
     */
    public function courses(): HasMany {
        return $this->hasMany(Course::class);
    }
}
