<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfessionalTrajectory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'color',
    ];

    /**
     * Relationship - professional trajectory to user
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship professional trajectory to disciplines
     * @return BelongsToMany
     */
    public function professionalTrajectories(): BelongsToMany {
        return $this->belongsToMany(Discipline::class, 'discipline_professional_trajectory');
    }
}
