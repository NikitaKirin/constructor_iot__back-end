<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Platform\Models\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'       => 'array',
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'name',
        'email',
        'permissions',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
    ];

    /**
     * Relationship - user to institutes
     * @return HasMany
     */
    public function institutes(): HasMany {
        return $this->hasMany(Institute::class);
    }

    /**
     * Relationship - user to educational directions
     * @return HasMany
     */
    public function educationalDirections(): HasMany {
        return $this->hasMany(EducationalDirection::class);
    }

    /**
     * Relationship - user to semesters
     * @return HasMany
     */
    public function semesters(): HasMany {
        return $this->hasMany(Semester::class);
    }

    /**
     * Relationship - user to frequently asked question
     * @return HasMany
     */
    public function frequentlyAskedQuestions(): HasMany {
        return $this->hasMany(FrequentlyAskedQuestion::class);
    }

    /**
     * Relationship - user to educational modules
     * @return HasMany
     */
    public function educationalModules(): HasMany {
        return $this->hasMany(EducationalModule::class);
    }


    /**
     * Relationship - user to disciplines
     * @return HasMany
     */
    public function disciplines(): HasMany {
        return $this->hasMany(Discipline::class);
    }

    /**
     * Relationship - user to professional trajectories
     * @return HasMany
     */
    public function professionalTrajectories(): HasMany {
        return $this->hasMany(ProfessionalTrajectory::class);
    }

    /**
     * Relationship - user to professions
     * @return HasMany
     */
    public function professions(): HasMany {
        return $this->hasMany(Profession::class);
    }

    /**
     * Relationship - user to skills
     * @return HasMany
     */
    public function skills(): HasMany {
        return $this->hasMany(Skill::class);
    }

    /**
     * Relationship - user to realizations
     * @return HasMany
     */
    public function realizations(): HasMany {
        return $this->hasMany(Realization::class);
    }

    /**
     * Relationship - user to partners
     * @return HasMany
     */
    public function partners(): HasMany {
        return $this->hasMany(Partner::class);
    }

    /**
     * Relationship - user to courses
     * @return HasMany
     */
    public function courses(): HasMany {
        return $this->hasMany(Course::class);
    }

    /**
     * Relationship - user to employees
     * @return HasMany
     */
    public function employees(): HasMany {
        return $this->hasMany(Employee::class);
    }

    /**
     * Relationship - positions to employees
     * @return HasMany
     */
    public function positions(): HasMany {
        return $this->hasMany(Position::class);
    }

    /**
     * Relationship - user to reviews
     * @return HasMany
     */
    public function reviews(  ): HasMany {
        return $this->hasMany(Review::class);
    }
}
