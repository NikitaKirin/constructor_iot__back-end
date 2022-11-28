<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Screen\AsSource;

class Discipline extends Model
{
    use HasFactory, SoftDeletes, AsSource, Userable;

    protected $fillable = [
        'title',
        'description',
    ];

    /**
     * Relationship - discipline to educational modules
     * @return BelongsToMany
     */
    public function educationalModules(): BelongsToMany {
        return $this->belongsToMany(EducationalModule::class, 'educational_module_discipline');
    }

    /**
     * Relationship discipline to professional trajectories
     * @return BelongsToMany
     */
    public function professionalTrajectories(): belongsToMany {
        return $this->belongsToMany(ProfessionalTrajectory::class, 'discipline_professional_trajectory')
                    ->withPivot('discipline_level_digital_value');
    }

    /**
     * Relationship discipline to courses
     * @return HasMany
     */
    public function courses(): HasMany {
        return $this->hasMany(Course::class);
    }
}
