<?php

declare(strict_types=1);

use App\Models\AdmissionCommitteeContactsBlock;
use App\Models\Course;
use App\Models\Discipline;
use App\Models\EducationalModule;
use App\Models\Employee;
use App\Models\FAQ;
use App\Models\Institute;
use App\Models\Partner;
use App\Models\Profession;
use App\Models\ProfessionalTrajectory;
use App\Models\Review;
use App\Models\SocialNetworksBlock;
use App\Orchid\Layouts\Profession\ProfessionListLayout;
use App\Orchid\Screens\AdmissionCommitteeContactsBlock\AdmissionCommitteeContactsBlockEditScreen;
use App\Orchid\Screens\AdmissionCommitteeContactsBlock\AdmissionCommitteeContactsBlockProfileScreen;
use App\Orchid\Screens\Course\CourseEditScreen;
use App\Orchid\Screens\Course\CourseListScreen;
use App\Orchid\Screens\Course\CourseProfileScreen;
use App\Orchid\Screens\Discipline\DisciplineEditScreen;
use App\Orchid\Screens\Discipline\DisciplineListScreen;
use App\Orchid\Screens\Discipline\DisciplineProfileScreen;
use App\Orchid\Screens\EducationalProgram\EducationalProgramListScreen;
use App\Orchid\Screens\EducationalModule\EducationalModuleEditScreen;
use App\Orchid\Screens\EducationalModule\EducationalModuleListScreen;
use App\Orchid\Screens\EducationalModule\EducationalModuleProfileScreen;
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
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

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

//Platform > Educational Directions
Route::screen('educationalPrograms', EducationalProgramListScreen::class)
    ->name('platform.educationalPrograms')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__('Образовательные программы'), route('platform.educationalPrograms'));
    });

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


// Platform > Semesters
/*Route::screen('semesters', SemesterListScreen::class)
     ->name('platform.semesters')
     ->breadcrumbs(function ( Trail $trail ) {
         return $trail
             ->parent('platform.index')
             ->push(__('Список семестров'), route('platform.semesters'));
     });*/

// Platform > EducationalModules
Route::screen('educational-modules', EducationalModuleListScreen::class)
    ->name('platform.educationalModules')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__("Список образовательных модулей"), \route('platform.educationalModules'));
    });

// Platform > EducationalModules > Create
Route::screen('educational-modules/create', EducationalModuleEditScreen::class)
    ->name('platform.educationalModules.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.educationalModules')
            ->push(__('Добавить образовательный модуль'), route('platform.educationalModules.create'));
    });

// Platform > EducationalModules > Profile
Route::screen('educational-modules/{educationalModule}/profile', EducationalModuleProfileScreen::class)
    ->name('platform.educationalModules.profile')
    ->breadcrumbs(function (Trail $trail, EducationalModule $educationalModule) {
        return $trail
            ->parent('platform.educationalModules')
            ->push(__("$educationalModule->title"), route('platform.educationalModules.profile', $educationalModule));
    });

// Platform > EducationalModules > Edit
Route::screen('educational-modules/{educationalModule}/edit', EducationalModuleEditScreen::class)
    ->name('platform.educationalModules.edit')
    ->breadcrumbs(function (Trail $trail, EducationalModule $educationalModule) {
        return $trail
            ->parent('platform.educationalModules')
            ->push(__("Изменить образовательный модуль: {$educationalModule->title}"),
                route('platform.educationalModules.edit', $educationalModule));
    });

// Platform > Disciplines
Route::screen('disciplines', DisciplineListScreen::class)
    ->name('platform.disciplines')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push(__("Список дисциплин"), \route('platform.disciplines'));
    });

// Platform > Disciplines > Create
Route::screen('disciplines/create', DisciplineEditScreen::class)
    ->name('platform.disciplines.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.disciplines')
            ->push(__('Добавить новую дисциплину'), route('platform.disciplines.create'));
    });

// Platform > Disciplines > Profile
Route::screen('disciplines/{discipline}/profile', DisciplineProfileScreen::class)
    ->name('platform.disciplines.profile')
    ->breadcrumbs(function (Trail $trail, Discipline $discipline) {
        return $trail
            ->parent('platform.disciplines')
            ->push(__("$discipline->title"), route('platform.disciplines.profile', $discipline));
    });

// Platform > Disciplines > Edit
Route::screen('disciplines/{discipline}/edit', DisciplineEditScreen::class)
    ->name('platform.disciplines.edit')
    ->breadcrumbs(function (Trail $trail, Discipline $discipline) {
        return $trail
            ->parent('platform.disciplines')
            ->push(__("Изменить дисциплину: {$discipline->title}"),
                route('platform.disciplines.edit', $discipline));
    });


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

Route::screen('/telescope', TelescopeViewScreen::class)
    ->name('telescope.index');

// Example...
Route::screen('example', ExampleScreen::class)
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
Route::screen('example-advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');

//Route::screen('idea', Idea::class, 'platform.screens.idea');
