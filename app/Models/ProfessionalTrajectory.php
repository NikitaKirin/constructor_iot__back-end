<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class ProfessionalTrajectory extends Model
{
    use HasFactory, SoftDeletes, Userable, AsSource, Attachable, Filterable;

    protected $fillable = [
        'title',
        'description',
        'color',
        'abbreviated_name',
    ];

    protected $allowedSorts = [
        'title',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'title',
        'slug',
    ];

    /**
     * Relationship professional trajectory to disciplines
     * @return BelongsToMany
     */
    public function disciplines(): BelongsToMany {
        return $this->belongsToMany(Discipline::class, 'discipline_professional_trajectory')
                    ->withPivot('discipline_level_digital_value');
    }

    public function icons() {
        return $this->hasMany(Attachment::class)->where('group', 'icons');
    }

    public function professions(): BelongsToMany {
        return $this->belongsToMany(Profession::class, 'profession_professional_trajectory');
    }

}
