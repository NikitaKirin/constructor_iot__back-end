<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Institute extends Model
{
    use HasFactory, SoftDeletes, AsSource, Filterable;

    protected $fillable = [
        'title',
        'abbreviation',
    ];


    protected $allowedSorts = [
        'title',
        'abbreviation',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters = [
        'title',
        'abbreviation',
    ];

    /**
     * Relationship - institute to user
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship - institute to educational directions
     * @return HasMany
     */
    public function educationalDirections(): HasMany {
        return $this->hasMany(EducationalDirection::class);
    }

    /**
     * Relationship institute to social networks block
     * @return HasOne
     */
    public function socialNetworksBlock(): HasOne {
        return $this->hasOne(SocialNetworksBlock::class);
    }

    /**
     * Relationship institute to admission
     */
    public function admissionComitteeContactsBlock(): HasOne {
        return $this->hasOne(AdmissionCommitteeContactsBlock::class);
    }
}
