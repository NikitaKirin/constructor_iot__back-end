<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discipline extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Relationship - discipline to user
     * @return BelongsTo
     */
    public function user(  ): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship - discipline to educational modules
     * @return BelongsToMany
     */
    public function educationalModules(  ): BelongsToMany {
        return $this->belongsToMany(EducationalModule::class, 'educational_module_discipline');
    }

    /**
     * Relationship discipline to professional trajectories
     * @return BelongsToMany
     */
    public function professionalTrajectories(  ): BelongsToMany {
        return $this->belongsToMany(ProfessionalTrajectory::class, 'discipline_professional_trajectory');
    }
}
