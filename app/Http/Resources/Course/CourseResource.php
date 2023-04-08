<?php

namespace App\Http\Resources\Course;

use App\Http\Resources\EducationalProgram\EducationalProgramResource;
use App\Http\Resources\Partner\PartnerResource;
use App\Http\Resources\ProfessionalTrajectory\ProfessionalTrajectoryResource;
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
            'limit'                     => $this->limit,
            'realization'               => $this->realization->title,
            'professional_trajectories' => $this->whenLoaded('courseAssembly', function () {
                return ProfessionalTrajectoryResource::collection($this->courseAssembly->professionalTrajectories);
            }),
            'partner'                   => new PartnerResource($this->whenLoaded('partner')),
            'educationalProgramms'      => $this->when(Route::currentRouteNamed('partners.courses.show'), function () {
                $disciplines = $this->courseAssembly->disciplines;
                $educationalProgramms = $disciplines->map(
                    fn(Discipline $discipline) => $discipline->educationalPrograms
                )->first();
                return EducationalProgramResource::collection($educationalProgramms);
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
