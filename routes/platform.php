<?php

declare(strict_types=1);

use App\Models\AdmissionCommitteeContactsBlock;
use App\Models\Course;
use App\Models\CourseAssembly;
use App\Models\Discipline;
use App\Models\Employee;
use App\Models\FAQ;
use App\Models\Institute;
use App\Models\Partner;
use App\Models\Profession;
use App\Models\ProfessionalTrajectory;
use App\Models\Review;
use App\Models\SocialNetworksBlock;
use App\Orchid\Screens\AdmissionCommitteeContactsBlock\AdmissionCommitteeContactsBlockEditScreen;
use App\Orchid\Screens\AdmissionCommitteeContactsBlock\AdmissionCommitteeContactsBlockProfileScreen;
use App\Orchid\Screens\Course\CourseEditScreen;
use App\Orchid\Screens\Course\CourseListScreen;
use App\Orchid\Screens\Course\CourseProfileScreen;
use App\Orchid\Screens\CourseAssemblies\CourseAssemblyEditScreen;
use App\Orchid\Screens\CourseAssemblies\CourseAssemblyListScreen;
use App\Orchid\Screens\CourseAssemblies\CourseAssemblyProfileScreen;
use App\Orchid\Screens\Discipline\DisciplineEditScreen;
use App\Orchid\Screens\Discipline\DisciplineListScreen;
use App\Orchid\Screens\Discipline\DisciplineProfileScreen;
use App\Orchid\Screens\EducationalProgram\EducationalProgramListScreen;
use App\Orchid\Screens\Employee\EmployeeEditScreen;
use App\Orchid\Screens\Employee\EmployeeListScreen;
use App\Orchid\Screens\Employee\EmployeeProfileScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\FAQ\FAQEditScreen;
use App\Orchid\Screens\FAQ\FAQListScreen;
use App\Orchid\Screens\Institute\InstituteEditScreen;
use App\Orchid\Screens\Institute\InstituteListScreen;
use App\Orchid\Screens\Institute\InstituteProfileScreen;
use App\Orchid\Screens\Partner\PartnerEditScreen;
use App\Orchid\Screens\Partner\PartnerListScreen;
use App\Orchid\Screens\Partner\PartnerProfileScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Profession\ProfessionEditScreen;
use App\Orchid\Screens\Profession\ProfessionListScreen;
use App\Orchid\Screens\Profession\ProfessionProfileScreen;
use App\Orchid\Screens\ProfessionalTrajectory\ProfessionalTrajectoryEditScreen;
use App\Orchid\Screens\ProfessionalTrajectory\ProfessionalTrajectoryListScreen;
use App\Orchid\Screens\Review\ReviewEditScreen;
use App\Orchid\Screens\Review\ReviewListScreen;
use App\Orchid\Screens\Review\ReviewProfileScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\SocialNetworksBlock\SocialNetworksBlockEditScreen;
use App\Orchid\Screens\TelescopeViewScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Main
Route::get('/admin', function () {
   return redirect()->route('platform.educationalPrograms');
})->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Profile'), route('platform.profile'));
    });

// Platform > System > Users
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(function (Trail $trail, $user) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('User'), route('platform.systems.users.edit', $user));
    });

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.users')
            ->push(__('Create'), route('platform.systems.users.create'));
    });

// Platform > System > Users > User
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Users'), route('platform.systems.users'));
    });

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(function (Trail $trail, $role) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Role'), route('platform.systems.roles.edit', $role));
    });

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.systems.roles')
            ->push(__('Create'), route('platform.systems.roles.create'));
    });

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Roles'), route('platform.systems.roles'));
    });

Route::middleware(['access:analytics'])->group(function () {
    //Platform > System > Analytics
    Route::screen('analytics', \App\Orchid\Screens\AnalyticsScreen::class)
        ->name('platform.analytics')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__('Аналитика'), route('platform.analytics'));
        });

    //Platform > System > DetailAnalytics
    Route::screen('detail-analytics', \App\Orchid\Screens\DetailAnalyticsScreen::class)
        ->name('platform.detail-analytics')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__('Детальная аналитика'), route('platform.detail-analytics'));
        })
        ->where([
            'educational_program_id',
            'period',
        ]);
});

Route::middleware(['access:institutes'])->group(function () {
    //Platform > Institutes > Create
    Route::screen('institutes/create', InstituteEditScreen::class)
        ->name('platform.institutes.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.institutes')
                ->push(__('Create'), route('platform.institutes.create'));
        });

// Platform > Institutes > Profile
    Route::screen('institutes/{institute}/profile', InstituteProfileScreen::class)
        ->name('platform.institutes.profile')
        ->breadcrumbs(function (Trail $trail, Institute $institute) {
            return $trail
                ->parent('platform.institutes')
                ->push(__("{$institute->title}"), route('platform.institutes.profile', $institute));
        });

// Platform > Institutes > Edit
    Route::screen('institutes/{institute}/edit', InstituteEditScreen::class)
        ->name('platform.institutes.edit')
        ->breadcrumbs(function (Trail $trail, Institute $institute) {
            return $trail
                ->parent('platform.institutes')
                ->push(__('Изменить данные об институте'), route('platform.institutes.edit', $institute));
        });

// Platform > Institutes
    Route::screen('institutes', InstituteListScreen::class)
        ->name('platform.institutes')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__('Институты'), route('platform.institutes'));
        });

});

Route::middleware(['access:educationalPrograms'])->group(function () {
    //Platform > Educational Programms
    Route::screen('educationalPrograms', EducationalProgramListScreen::class)
        ->name('platform.educationalPrograms')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__('Образовательные программы'), route('platform.educationalPrograms'));
        });
});

Route::middleware(['access:employees'])->group(function () {
    // Platform > Employees
    Route::screen('employees', EmployeeListScreen::class)
        ->name('platform.employees')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__('Сотрудники'), route('platform.employees'));
        });

// Platform > Employees > Create
    Route::screen('employees/create', EmployeeEditScreen::class)
        ->name('platform.employees.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.employees')
                ->push(__('Создать нового сотрудника'), route('platform.employees.create'));
        });

// Platform > Employees > Edit
    Route::screen('employees/{employee}/edit', EmployeeEditScreen::class)
        ->name('platform.employees.edit')
        ->breadcrumbs(function (Trail $trail, $employee) {
            return $trail
                ->parent('platform.employees')
                ->push(__('Изменить данные сотрудника'), route('platform.employees.edit', $employee));
        });

// Platform > Employees > Profile
    Route::screen('employees/{employee}/profile', EmployeeProfileScreen::class)
        ->name('platform.employees.profile')
        ->breadcrumbs(function (Trail $trail, Employee $employee) {
            return $trail
                ->parent('platform.employees')
                ->push(__("$employee->full_name"), route('platform.employees.profile', $employee));
        });
});

Route::middleware(['access:partners'])->group(function () {
    // Platform > Partners
    Route::screen('partners', PartnerListScreen::class)
        ->name('platform.partners')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__("Партнеры"), route('platform.partners'));
        });

// Platform > Partners > Profile
    Route::screen('partners/{partner}/profile', PartnerProfileScreen::class)
        ->name('platform.partners.profile')
        ->breadcrumbs(function (Trail $trail, Partner $partner) {
            return $trail
                ->parent('platform.partners')
                ->push(__("$partner->title"), route('platform.partners.profile', $partner));
        });

// Platform > Partners > Create
    Route::screen('partners/create', PartnerEditScreen::class)
        ->name('platform.partners.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.partners')
                ->push(__("Добавить нового партнера"), route('platform.partners.create'));
        });

// Platform > Partners > Edit
    Route::screen('partners/{partner}/edit', PartnerEditScreen::class)
        ->name('platform.partners.edit')
        ->breadcrumbs(function (Trail $trail, Partner $partner) {
            $title = $partner->exists() ? "Изменить $partner->title" : "Добавить нового партнера";
            return $trail
                ->parent('platform.partners')
                ->push(__("$title"), route('platform.partners.edit', $partner));
        });
});

Route::middleware(['access:reviews'])->group(function () {
// Platform > Reviews
    Route::screen('reviews', ReviewListScreen::class)
        ->name('platform.reviews')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__('Список отзывов'), route('platform.reviews'));
        });

// Platform > Reviews > Profile
    Route::screen('reviews/{review}/profile', ReviewProfileScreen::class)
        ->name('platform.reviews.profile')
        ->breadcrumbs(function (Trail $trail, Review $review) {
            return $trail
                ->parent('platform.reviews')
                ->push(__("Отзыв: {$review->author}"), route('platform.reviews.profile', $review));
        });

// Platform > Reviews > Create
    Route::screen('reviews/create', ReviewEditScreen::class)
        ->name('platform.reviews.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.reviews')
                ->push(__('Добавить отзыв'), route('platform.reviews.create'));
        });

// Platform > Reviews > Edit
    Route::screen('reviews/{review}/edit', ReviewEditScreen::class)
        ->name('platform.reviews.edit')
        ->breadcrumbs(function (Trail $trail, Review $review) {
            return $trail
                ->parent('platform.reviews')
                ->push(__("Изменить отзыв: {$review->author}"), route('platform.reviews.edit', $review));
        });
});

Route::middleware(['access:disciplines'])->group(function () {
// Platform > disciplines
    Route::screen('disciplines', DisciplineListScreen::class)
        ->name('platform.disciplines')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__("Список дисциплин"), \route('platform.disciplines'));
        });

// Platform > disciplines > Create
    Route::screen('disciplines/create', DisciplineEditScreen::class)
        ->name('platform.disciplines.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.disciplines')
                ->push(__('Добавить образовательный модуль'), route('platform.disciplines.create'));
        });

// Platform > disciplines > Profile
    Route::screen('disciplines/{discipline}/profile', DisciplineProfileScreen::class)
        ->name('platform.disciplines.profile')
        ->breadcrumbs(function (Trail $trail, Discipline $discipline) {
            return $trail
                ->parent('platform.disciplines')
                ->push(__("$discipline->title"), route('platform.disciplines.profile', $discipline));
        });

// Platform > disciplines > Edit
    Route::screen('disciplines/{discipline}/edit', DisciplineEditScreen::class)
        ->name('platform.disciplines.edit')
        ->breadcrumbs(function (Trail $trail, Discipline $discipline) {
            return $trail
                ->parent('platform.disciplines')
                ->push(__("Изменить дисциплину: {$discipline->title}"),
                    route('platform.disciplines.edit', $discipline));
        });
});

Route::middleware(['access:courseAssemblies'])->group(function () {
    // Platform > courseAssemblies
    Route::screen('courseAssemblies', CourseAssemblyListScreen::class)
        ->name('platform.courseAssemblies')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__("Список курсовых сборок"), \route('platform.courseAssemblies'));
        });

// Platform > courseAssemblies > Create
    Route::screen('courseAssemblies/create', CourseAssemblyEditScreen::class)
        ->name('platform.courseAssemblies.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.courseAssemblies')
                ->push(__('Добавить новую курсовую сборку'), route('platform.courseAssemblies.create'));
        });

// Platform > courseAssemblies > Profile
    Route::screen('courseAssemblies/{courseAssembly}/profile', CourseAssemblyProfileScreen::class)
        ->name('platform.courseAssemblies.profile')
        ->breadcrumbs(function (Trail $trail, CourseAssembly $courseAssembly) {
            return $trail
                ->parent('platform.courseAssemblies')
                ->push(__("$courseAssembly->title"), route('platform.courseAssemblies.profile', $courseAssembly));
        });

// Platform > courseAssemblies > Edit
    Route::screen('courseAssemblies/{courseAssembly}/edit', CourseAssemblyEditScreen::class)
        ->name('platform.courseAssemblies.edit')
        ->breadcrumbs(function (Trail $trail, CourseAssembly $courseAssembly) {
            return $trail
                ->parent('platform.courseAssemblies')
                ->push(__("Изменить курсовую сборку: {$courseAssembly->title}"),
                    route('platform.courseAssemblies.edit', $courseAssembly));
        });
});

Route::middleware(['access:courses'])->group(function () {
    // Platform > Courses
    Route::screen('courses', CourseListScreen::class)
        ->name('platform.courses')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__("Список курсов"), \route('platform.courses'));
        });

// Platform > Courses > Create
    Route::screen('courses/create', CourseEditScreen::class)
        ->name('platform.courses.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.courses')
                ->push(__('Добавить новый курс'), route('platform.courses.create'));
        });

// Platform > Courses > Profile
    Route::screen('courses/{course}/profile', CourseProfileScreen::class)
        ->name('platform.courses.profile')
        ->breadcrumbs(function (Trail $trail, Course $course) {
            return $trail
                ->parent('platform.courses')
                ->push(__("$course->title"), route('platform.courses.profile', $course));
        });

// Platform > Courses > Edit
    Route::screen('courses/{course}/edit', CourseEditScreen::class)
        ->name('platform.courses.edit')
        ->breadcrumbs(function (Trail $trail, Course $course) {
            return $trail
                ->parent('platform.courses')
                ->push(__("Изменить курс: {$course->title}"),
                    route('platform.courses.edit', $course));
        });
});

Route::middleware(['access:contacts'])->group(function () {
    // Platform > AdmissionCommitteeContactsBlock > Profile
    Route::screen('admissionCommitteeContactsBlocks/{admissionCommitteeContactsBlock}/profile',
        AdmissionCommitteeContactsBlockProfileScreen::class)
        ->name('platform.admissionCommitteeContactsBlocks.profile')
        ->breadcrumbs(function (Trail $trail, AdmissionCommitteeContactsBlock $admissionCommitteeContactsBlock) {
            return $trail
                ->parent('platform.index')
                ->push(__("Контакты отборочной комиссии"),
                    route('platform.admissionCommitteeContactsBlocks.profile', $admissionCommitteeContactsBlock));
        });

// Platform > AdmissionCommitteeContactsBlock > Edit
    Route::screen('admissionCommitteeContactsBlocks/{admissionCommitteeContactsBlock}/edit',
        AdmissionCommitteeContactsBlockEditScreen::class)
        ->name('platform.admissionCommitteeContactsBlocks.edit')
        ->breadcrumbs(function (Trail $trail, AdmissionCommitteeContactsBlock $admissionCommitteeContactsBlock) {
            return $trail
                ->parent('platform.admissionCommitteeContactsBlocks.profile', $admissionCommitteeContactsBlock)
                ->push(__("Изменить контакты отборочной комиссии"),
                    route('platform.admissionCommitteeContactsBlocks.edit', $admissionCommitteeContactsBlock));
        });

// Platform > SocialNetworksBlock > Edit
    Route::screen('socialNetworksBlocks/{socialNetworksBlock}/edit',
        SocialNetworksBlockEditScreen::class)
        ->name('platform.socialNetworksBlocks.edit')
        ->breadcrumbs(function (Trail $trail, SocialNetworksBlock $socialNetworksBlock) {
            return $trail
                ->parent('platform.index')
                ->push(__("Изменить контакты отборочной комиссии"),
                    route('platform.socialNetworksBlocks.edit', $socialNetworksBlock));
        });
});

Route::middleware(['access:professionalTrajectories'])->group(function () {
    // Platform > ProfessionalTrajectories
    Route::screen('professionalTrajectories', ProfessionalTrajectoryListScreen::class)
        ->name('platform.professionalTrajectories')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__("Список профессиональных траекторий"), \route('platform.professionalTrajectories'));
        });

// Platform > ProfessionalTrajectories > Create
    Route::screen('professionalTrajectories/create', ProfessionalTrajectoryEditScreen::class)
        ->name('platform.professionalTrajectories.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.professionalTrajectories')
                ->push(__('Добавить новую траекторию'), route('platform.professionalTrajectories.create'));
        });

// Platform > ProfessionalTrajectories > Edit
    Route::screen('professionalTrajectories/{professionalTrajectory}/edit',
        ProfessionalTrajectoryEditScreen::class)
        ->name('platform.professionalTrajectories.edit')
        ->breadcrumbs(function (Trail $trail, ProfessionalTrajectory $professionalTrajectory) {
            return $trail
                ->parent('platform.professionalTrajectories')
                ->push(__("Изменить профессиональный трек"),
                    route('platform.professionalTrajectories.edit', $professionalTrajectory));
        });
});

Route::middleware(['access:professions'])->group(function () {

// Platform > Professions
    Route::screen('professions', ProfessionListScreen::class)
        ->name('platform.professions')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__("Список профессий"), \route('platform.professions'));
        });

// Platform > Professions > Create
    Route::screen('professions/create', ProfessionEditScreen::class)
        ->name('platform.professions.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.professions')
                ->push(__('Добавить новую профессию'), route('platform.professions.create'));
        });

// Platform > Professions > Edit
    Route::screen('professions/{profession}/edit',
        ProfessionEditScreen::class)
        ->name('platform.professions.edit')
        ->breadcrumbs(function (Trail $trail, Profession $profession) {
            return $trail
                ->parent('platform.professions')
                ->push(__("Изменить профессиональный трек"),
                    route('platform.professions.edit', $profession));
        });

// Platform > Professions > Profile
    Route::screen('professions/{profession}/profile', ProfessionProfileScreen::class)
        ->name('platform.professions.profile')
        ->breadcrumbs(function (Trail $trail, Profession $profession) {
            return $trail
                ->parent('platform.professions')
                ->push(__("{$profession->title}"), route('platform.institutes.profile', $profession));
        });
});

Route::middleware(['access:faq'])->group(function () {

// Platform > FAQ
    Route::screen('faq', FAQListScreen::class)
        ->name('platform.faq')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.index')
                ->push(__("FAQ"), route('platform.faq'));
        });

// Platform > FAQ > Create
    Route::screen('faq/create', FAQEditScreen::class)
        ->name('platform.faq.create')
        ->breadcrumbs(function (Trail $trail) {
            return $trail
                ->parent('platform.faq')
                ->push(__('Добавить новый вопрос'), route('platform.faq.create'));
        });

// Platform > FAQ > Edit
    Route::screen('faq/{faq}/edit', FAQEditScreen::class)
        ->name('platform.faq.edit')
        ->breadcrumbs(function (Trail $trail, FAQ $faq) {
            return $trail
                ->parent('platform.faq')
                ->push(__("Изменить вопрос"),
                    route('platform.faq.edit', $faq));
        });
});

Route::middleware(['access:logs'])->group(function () {
    Route::screen('/telescope', TelescopeViewScreen::class)
        ->name('telescope.index');
});


// Example...
/*Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Example screen');
    });

Route::screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('example-charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('example-editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('example-cards', ExampleCardsScreen::class)->name('platform.example.cards');
Route::screen('example-advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');*/

//Route::screen('idea', Idea::class, 'platform.screens.idea');
