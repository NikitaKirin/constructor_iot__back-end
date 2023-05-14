<?php

namespace Tests\Feature\Api\v1;

use App\Models\Course;
use App\Models\Partner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PartnerTest extends TestCase
{
    use RefreshDatabase;

    public function testPartnerIndexAssertJsonStructure() {
        Partner::factory(5)->create()->sortBy('title')->first();
        $response = $this->get(route('partners.index'));
        $response->assertOk()->assertJsonStructure([
            'partners' => [
                '*' => [
                    'id',
                    'title',
                    'site_link',
                    'logo',
                ],
            ],
        ]);
    }

    public function testPartnersIndexAssertJsonValue() {
        $testPartner = Partner::factory(5)->create()->sortBy('title')->first();

        $response = $this->get(route('partners.index'));

        $response->assertOk();

        $response->assertJson(
            fn(AssertableJson $json) => $json->has(
                'partners.0',
                fn($json) => $json->where('id', $testPartner->id)
                    ->where('title', $testPartner->title)
                    ->where('site_link', $testPartner->site_link)
                    ->etc()
            )
        );
    }

    public function testPartnersCoursesIndexAsserJsonStructure() {
        Partner::factory(5)->hasCourses(4)->create()->sortBy('title')->first();
        $response = $this->get(route('partners.courses.index'));
        $response->assertOk()->assertJsonStructure([
            'courses' => [
                '*' => [
                    'id',
                    'title',
                    'description',
                    'realization',
                    'professional_trajectories' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'abbreviated_name',
                            'color',
                            'course_assembly_evaluation',
                        ],
                    ],
                    'partner'                   => [
                        'id',
                        'title',
                        'site_link',
                        'logo',
                    ],
                ],
            ],
        ]);
    }

    public function testPartnersCoursesIndexAssertJsonValue() {
        Partner::factory()->hasCourses()->create();
        $course = Course::first();
        $response = $this->get(route('partners.courses.index'));
        $response->assertJson(fn(AssertableJson $json) => $json->has(
            'courses.0',
            fn(AssertableJson $json) => $json->where('id', $course->id)
                ->where('title', $course->title)
                ->where('description', $course->description)
                ->where('realization', $course->realization->title)
                ->has(
                    'partner',
                    fn(AssertableJson $json) => $json->where('id', $course->partner->id)
                        ->where('title', $course->partner->title)
                        ->where('site_link', $course->partner->site_link)
                        ->etc()
                )
                ->etc()
        )->etc()
        );
    }

    public function testPartnerCoursesShowAssertJsonStructure() {
        $course = Course::factory()->for(Partner::factory())->create()->first();
        $response = $this->get(route('partners.courses.show', $course));
        $response->assertOk()->assertJsonStructure([
                'course' => [
                    'id',
                    'title',
                    'description',
                    'realization',
                    'professional_trajectories' => [
                        '*' => [
                            'id',
                            'title',
                            'description',
                            'abbreviated_name',
                            'color',
                            'course_assembly_evaluation',
                        ],
                    ],
                    'partner'                   => [
                        'id',
                        'title',
                        'site_link',
                        'logo',
                    ],
                ],
            ]
        );
    }

    public function testPartnerCoursesShowAssertJsonValue() {
        $course = Course::factory()->for(Partner::factory())->create()->first();
        $response = $this->get(route('partners.courses.show', $course));
        $response->assertOk()->assertJson(fn(AssertableJson $json) => $json->has(
            'course',
            fn(AssertableJson $json) => $json->where('id', $course->id)
                ->where('title', $course->title)
                ->where('description', $course->description)
                ->where('realization', $course->realization->title)
                ->has('partner',
                    fn(AssertableJson $json) => $json->where('id', $course->partner->id)
                        ->where('title', $course->partner->title)
                        ->where('site_link', $course->partner->site_link)
                        ->etc()
                )
                ->etc()
        )
        );
    }

    public function testNonExistingPartnersCoursesShow() {
        Course::factory()->create();
        $course_id = Course::latest()->first()->id + 1;
        $this->get(route('partners.courses.show', ['course' => $course_id]))->assertStatus(404);
    }
}
