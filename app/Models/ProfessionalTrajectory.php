<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfessionalTrajectory extends Model
{
    use HasFactory, SoftDeletes, Userable;

    protected $fillable = [
        'title',
        'description',
        'color',
    ];

    /**
     * Relationship professional trajectory to disciplines
     * @return BelongsToMany
     */
    public function disciplines(): BelongsToMany {
        return $this->belongsToMany(Discipline::class, 'discipline_professional_trajectory');
    }
}
