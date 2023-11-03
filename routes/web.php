<?php

use App\Livewire\Faq;
use App\Livewire\User;
// use App\Livewire\CompleteProfile;
use App\Livewire\Voting;
use App\Livewire\Section;
use App\Livewire\HomePage;
use App\Livewire\Position;
use App\Livewire\Dashboard;
use App\Livewire\Partylist;
use App\Livewire\Organization;
use App\Livewire\PastElection;
use App\Livewire\ElectionResult;
use App\Livewire\ThankYouMessage;
use App\Livewire\UpcomingElection;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogOutController;
use App\Livewire\CourseResource\EditCourse;
use App\Livewire\CourseResource\ListCourses;
use App\Http\Controllers\StoreVoteController;
use App\Livewire\CourseResource\CreateCourse;
use App\Livewire\SectionResource\EditSection;
use App\Http\Controllers\GoogleAuthController;
use App\Livewire\SectionResource\ListSections;
use App\Livewire\ElectionResource\EditElection;
use App\Livewire\SectionResource\CreateSection;
use App\Livewire\ElectionResource\ListElections;
use App\Livewire\ElectionResource\CreateElection;
use App\Livewire\DepartmentResource\EditDepartment;
use App\Livewire\DepartmentResource\ListDepartments;
use App\Livewire\DepartmentResource\CreateDepartment;

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

    Route::get('/organizations', Organization::class)->name('organizations');
    Route::get('/partylists', Partylist::class)->name('partylists');
    Route::get('/users', User::class)->name('users');
    Route::get('/positions', Position::class)->name('positions');
    Route::prefix('elections')->group(function () {
        Route::get('/', ListElections::class)->name('elections.index')->lazy();
        Route::get('/create', CreateElection::class)->name('elections.create')->lazy();
        Route::get('/{election}/edit', EditElection::class)->name('elections.edit')->lazy();
    });

    Route::get('/faqs', Faq::class)->name('faqs');

});

Route::get('/', HomePage::class)->name('home');
Route::get('/upcoming-elections', UpcomingElection::class)->name('upcoming.election');
Route::get('/past-elections', PastElection::class)->name('past.election');

Route::get('/faq', Faq::class);

// Route::get('/complete-profile', CompleteProfile::class)->middleware('auth')->name('complete.profile');

Route::prefix('election')->middleware(['auth', 'profileCompleted'])->group(function () {
    Route::get('/{election}', Voting::class)->name('start.voting');
    Route::post('/{election}', [StoreVoteController::class, 'store'])->name('vote.store');
    Route::get('/{election}/thank-you', ThankYouMessage::class)->name('thank-you.index');
    Route::get('/{election}/results', ElectionResult::class)->name('election.result');
});

Route::post('/logout', LogOutController::class)->name('logout');

Route::get('/auth/google', [GoogleAuthController::class, 'signin'])->name('google.login');
Route::get('/callback', [GoogleAuthController::class, 'callback']);
