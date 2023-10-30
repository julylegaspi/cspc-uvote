<?php

use App\Livewire\Faq;
use App\Livewire\User;
use App\Livewire\Course;
// use App\Livewire\CompleteProfile;
use App\Livewire\Voting;
use App\Livewire\Section;
use App\Livewire\HomePage;
use App\Livewire\Position;
use App\Livewire\Dashboard;
use App\Livewire\Partylist;
use App\Livewire\Department;
use App\Livewire\Organization;
use App\Livewire\PastElection;
use App\Livewire\UpcomingElection;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogOutController;
use App\Http\Controllers\StoreVoteController;
use App\Http\Controllers\GoogleAuthController;
use App\Livewire\ElectionResource\ListElections;

Route::middleware('guest')->group(function() {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('authenticate');
});

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard')->lazy();
    Route::get('/departments', Department::class)->name('departments');
    Route::get('/courses', Course::class)->name('courses');
    Route::get('/sections', Section::class)->name('sections');
    Route::get('/organizations', Organization::class)->name('organizations');
    Route::get('/partylists', Partylist::class)->name('partylists');
    Route::get('/users', User::class)->name('users');
    Route::get('/positions', Position::class)->name('positions');
    Route::prefix('elections')->group(function () {
        Route::get('/', ListElections::class)->name('elections.index');
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
});

Route::post('/logout', LogOutController::class)->name('logout');

Route::get('/auth/google', [GoogleAuthController::class, 'signin']);
Route::get('/callback', [GoogleAuthController::class, 'callback']);
