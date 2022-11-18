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
use Orchid\Screen\AsSource;

class ProfessionalTrajectory extends Model
{
    use HasFactory, SoftDeletes, Userable, AsSource, Attachable;

    protected $fillable = [
        'title',
        'description',
        'color',
        'slug',
        'sum_discipline_levels_points',
    ];

    /**
     * Relationship professional trajectory to disciplines
     * @return BelongsToMany
     */
    public function disciplines(): BelongsToMany {
        return $this->belongsToMany(Discipline::class, 'discipline_professional_trajectory')
                    ->withPivot('discipline_level_id');
    }

    public function icons() {
        return $this->hasMany(Attachment::class)->where('group', 'icons');
    }

    public static function countSumDisciplineLevelsPoints( ?ProfessionalTrajectory $professionalTrajectory = null ): int|Collection {
        // Получаем коллекцию данных по структуре: id => количество баллов
        $disciplineLevels = DisciplineLevel::all(['id', 'digital_value'])
                                           ->groupBy('id')
                                           ->map(fn( $item ) => $item->value('digital_value'))
                                           ->collect();

        // Получаем сумму баллов определенной траектории
        if ( $professionalTrajectory ) {
            $rows = DB::table('discipline_professional_trajectory')->where('professional_trajectory_id',
                $professionalTrajectory->id)->get();
            return collect($rows)->map(function ( $row ) use ( $disciplineLevels ) {
                return $disciplineLevels->get($row->discipline_level_id);
            })->sum();
        }

        return DB::table('discipline_professional_trajectory')
                 ->get()
                 ->groupBy('professional_trajectory_id')
                 ->map(function ( Collection $professionalTrajectoryCollection ) use ( $disciplineLevels ) {
                     return collect($professionalTrajectoryCollection->map(fn( $professionalTrajectoryCollectionItem ) => $disciplineLevels->get
                     ($professionalTrajectoryCollectionItem->discipline_level_id)))->sum();
                 });
    }

}
