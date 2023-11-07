<?php

use App\Livewire\Faq;
use App\Livewire\Voting;
use App\Livewire\HomePage;
use App\Livewire\Dashboard;
use App\Livewire\PastElection;
use App\Livewire\ElectionResult;
use App\Livewire\CompleteProfile;
use App\Livewire\ThankYouMessage;
use App\Livewire\UpcomingElection;
use App\Livewire\FaqResource\EditFaq;
use Illuminate\Support\Facades\Route;
use App\Livewire\FaqResource\ListFaqs;
use App\Livewire\FaqResource\CreateFaq;
use App\Livewire\UserResource\EditUser;
use App\Livewire\UserResource\ListUsers;
use App\Http\Controllers\LoginController;
use App\Livewire\UserResource\CreateUser;
use App\Http\Controllers\LogOutController;
use App\Livewire\CourseResource\EditCourse;
use App\Livewire\CourseResource\ListCourses;
use App\Http\Controllers\StoreVoteController;
use App\Livewire\CourseResource\CreateCourse;
use App\Livewire\SectionResource\EditSection;
use App\Http\Controllers\GoogleAuthController;
use App\Livewire\ActivityLog;
use App\Livewire\SectionResource\ListSections;
use App\Livewire\ElectionResource\EditElection;
use App\Livewire\PositionResource\EditPosition;
use App\Livewire\SectionResource\CreateSection;
use App\Livewire\ElectionResource\ListElections;
use App\Livewire\PositionResource\ListPositions;
use App\Livewire\ElectionResource\CreateElection;
use App\Livewire\PartylistResource\EditPartylist;
use App\Livewire\PositionResource\CreatePosition;
use App\Livewire\PartylistResource\ListPartylists;
use App\Livewire\DepartmentResource\EditDepartment;
use App\Livewire\PartylistResource\CreatePartylist;
use App\Livewire\DepartmentResource\ListDepartments;
use App\Livewire\DepartmentResource\CreateDepartment;
use App\Livewire\OrganizationResource\EditOrganization;
use App\Livewire\OrganizationResource\ListOrganizations;
use App\Livewire\OrganizationResource\CreateOrganization;

Route::middleware('guest')->group(function() {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard')->lazy();

    Route::prefix('departments')->group(function () {
        Route::get('/', ListDepartments::class)->name('departments.index');
        Route::get('/create', CreateDepartment::class)->name('departments.create');
        Route::get('/{department}/edit', EditDepartment::class)->name('departments.edit')->lazy();
    });

    Route::prefix('courses')->group(function () {
        Route::get('/', ListCourses::class)->name('courses.index');
        Route::get('/create', CreateCourse::class)->name('courses.create');
        Route::get('/{course}/edit', EditCourse::class)->name('courses.edit')->lazy();

    });
    
    Route::prefix('sections')->group(function () {
        Route::get('/', ListSections::class)->name('sections.index');
        Route::get('/create', CreateSection::class)->name('sections.create');
        Route::get('/{section}/edit', EditSection::class)->name('sections.edit')->lazy();
    });

    Route::prefix('organizations')->group(function () {
        Route::get('/', ListOrganizations::class)->name('organizations.index');
        Route::get('/create', CreateOrganization::class)->name('organizations.create');
        Route::get('/{organization}/edit', EditOrganization::class)->name('organizations.edit')->lazy();
    });

    Route::prefix('partylists')->group(function () {
        Route::get('/', ListPartylists::class)->name('partylists.index');
        Route::get('/create', CreatePartylist::class)->name('partylists.create');
        Route::get('/{partylist}/edit', EditPartylist::class)->name('partylists.edit')->lazy();
    });
    
    Route::prefix('users')->group(function () {
        Route::get('/', ListUsers::class)->name('users.index');
        Route::get('/create', CreateUser::class)->name('users.create');
        Route::get('/{user}/edit', EditUser::class)->name('users.edit')->lazy();
    });
    
    Route::prefix('positions')->group(function () {
        Route::get('/', ListPositions::class)->name('positions.index');
        Route::get('/create', CreatePosition::class)->name('positions.create');
        Route::get('/{position}/edit', EditPosition::class)->name('positions.edit')->lazy();
    });

    Route::prefix('elections')->group(function () {
        Route::get('/', ListElections::class)->name('elections.index');
        Route::get('/create', CreateElection::class)->name('elections.create');
        Route::get('/{election}/edit', EditElection::class)->name('elections.edit')->lazy();
    });

    Route::prefix('faqs')->group(function () {
        Route::get('/', ListFaqs::class)->name('faqs.index');
        Route::get('/create', CreateFaq::class)->name('faqs.create');
        Route::get('/{faq}/edit', EditFaq::class)->name('faqs.edit')->lazy();
    });

    Route::prefix('logs')->group(function () {
        Route::get('/', ActivityLog::class)->name('activity.log.index')->lazy();
    });

});

Route::get('/', HomePage::class)->middleware('profileCompleted')->name('home');
Route::get('/upcoming-elections', UpcomingElection::class)->name('upcoming.election');
Route::get('/past-elections', PastElection::class)->name('past.election');

Route::get('/faq', Faq::class);

Route::get('/complete-profile', CompleteProfile::class)->middleware('auth')->name('complete.profile');

Route::prefix('election')->middleware(['auth', 'profileCompleted'])->group(function () {
    Route::get('/{election}', Voting::class)->name('start.voting');
    Route::post('/{election}', [StoreVoteController::class, 'store'])->name('vote.store');
    Route::get('/{election}/thank-you', ThankYouMessage::class)->name('thank-you.index');
    Route::get('/{election}/results', ElectionResult::class)->name('election.result');
});

Route::post('/logout', LogOutController::class)->name('logout');

Route::get('/auth/google', [GoogleAuthController::class, 'signin'])->name('google.login');
Route::get('/callback', [GoogleAuthController::class, 'callback']);
