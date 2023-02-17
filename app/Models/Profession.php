<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Profession extends Model
{
    use HasFactory, SoftDeletes, Userable, Attachable, AsSource, Filterable;

    protected $fillable = [
        'title',
        'description',
        'headHunter_title',
        'vacancies_count',
        'maximal_salary',
        'minimal_salary',
        'median_salary',
    ];

    public function professionalTrajectories(): BelongsToMany {
        return $this->belongsToMany(ProfessionalTrajectory::class, 'profession_professional_trajectory');
    }

    /**
     * Relationship - review to attachment (orchid)
     * @return HasOne
     */
    public function photo(): HasOne {
        return $this->hasOne(Attachment::class, 'id', 'photo_id')
                    ->withDefault();
    }
}
