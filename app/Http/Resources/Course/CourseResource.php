<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\EducationalProgram\EducationalProgramResource;
use App\Http\Resources\Partner\PartnerResource;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResource;
use App\Models\CourseAssembly;
use App\Models\Discipline;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;
use Orchid\Attachment\Models\Attachment;

/** @mixin \App\Models\Course */
class CourseResource extends JsonResource
{
    public static $wrap = 'course';

    /**
     * @param Request $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id'                        => $this->id,
            'title'                     => $this->title,
            'description'               => $this->description,
            'realization'               => $this->realization->title,
            'professional_trajectories' => $this->whenLoaded('courseAssemblies', function () {
                $professionalTrajectories = $this->courseAssemblies->map(
                    fn(CourseAssembly $courseAssembly) => $courseAssembly->professionalTrajectories
                )->first();
                if(collect($professionalTrajectories)->count() > 0) {
                    return ProfessionalTrajectoryResource::collection(collect($professionalTrajectories)->unique('id'));
                }
                return [];
            }),
            'partner'                   => new PartnerResource($this->whenLoaded('partner')),
            'educational_programms'      => $this->when(Route::currentRouteNamed('partners.courses.show'), function () {
                $courseAssemblies = $this->courseAssemblies;
                $educationalPrograms = $courseAssemblies->map(
                    fn(CourseAssembly $courseAssembly) => $courseAssembly->discipline->educationalPrograms
                )->first();
                if(collect($educationalPrograms)->count() > 0){
                    return EducationalProgramResource::collection(collect($educationalPrograms)->unique('id'));
                }
                return [];
            }),
            // ? N+1 problem
            'video'                     => $this->whenLoaded('attachment',
                fn() => $this->getAttachmentResource($this->video)
            ),
            'presentation'              => $this->whenLoaded('attachment',
                fn() => $this->getAttachmentResource($this->presentation)
            ),
            'documents'                 => $this->whenLoaded('attachment', function () {
                return collect($this->documents)->map(function (Attachment $attachment) {
                    return $this->getAttachmentResource($attachment, withExtension: true);
                });
            }),
        ];
    }

    private function getAttachmentResource(Attachment $attachment, $withExtension = false): array|null {
        if (!$attachment->exists) {
            return null;
        }
        if ($withExtension) {
            return [
                'name'      => $attachment->original_name,
                'extension' => $attachment->extension,
                'ulr'       => $attachment->url(),
            ];
        }
        return [
            'name' => $attachment->original_name,
            'url'  => $attachment->url(),
        ];
    }
}
