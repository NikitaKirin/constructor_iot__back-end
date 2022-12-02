<?php

namespace App\Models;

use App\Traits\Userable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'slug',
        'sum_discipline_levels_points',
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

    public static function countSumDisciplineLevelsPoints( ?ProfessionalTrajectory $professionalTrajectory = null ): int|Collection {
        // Получаем коллекцию данных по структуре: id => количество баллов
        /*$disciplineLevels = DisciplineLevel::all(['id', 'digital_value'])
                                           ->groupBy('id')
                                           ->map(fn( $item ) => $item->value('digital_value'))
                                           ->collect();*/

        // Получаем сумму баллов определенной траектории
        if ( $professionalTrajectory ) {
            $rows = DB::table('discipline_professional_trajectory')->where('professional_trajectory_id',
                $professionalTrajectory->id)->get();
            return collect($rows)->map(function ( $row ) {
                return $row->discipline_level_digital_value;
            })->sum();
        }

        return DB::table('discipline_professional_trajectory')
                 ->get()
                 ->groupBy('professional_trajectory_id')
                 ->map(function ( Collection $professionalTrajectoryCollection ) {
                     return collect($professionalTrajectoryCollection->map(fn( $professionalTrajectoryCollectionItem
                     ) => $professionalTrajectoryCollectionItem->discipline_level_digital_value))->sum();
                 });
    }

    /*public static function countSumDisciplineLevelsPoints() {
        // Получаем коллекцию данных по структуре: id => количество баллов
        $disciplineLevels = DisciplineLevel::all(['id', 'digital_value'])
                                           ->groupBy('id')
                                           ->map(fn( $item ) => $item->value('digital_value'))
                                           ->collect();
        /*$result = ProfessionalTrajectory::all(['id'])
                                        ->groupBy('id')
                                        ->map(fn( $item ) => 0)
                                        ->toArray();*/
    /*$educationalModules = EducationalModule::whereHas('disciplines',
        fn( Builder $query ) => $query->whereHas('professionalTrajectories'))
                                           ->get();
    $result = collect($educationalModules)
        ->map(function ( EducationalModule $educationalModule ) {
            return [
                $educationalModule->title,
                $educationalModule->is_spec,
                $educationalModule->disciplines()
                                  ->whereHas('professionalTrajectories')
                                  ->get()
                                  ->map(function ( Discipline $discipline ) {
                                      return [
                                          $discipline->title => $discipline->professionalTrajectories
                                              ->map(function ( ProfessionalTrajectory $professionalTrajectory ) {
                                                  return [
                                                      $professionalTrajectory->title => $professionalTrajectory->discipline_level_id,
                                                  ];
                                              })->collapse(),
                                      ];
                                  }),
            ];
        });

    return $result;*/
    /* }*/

}
