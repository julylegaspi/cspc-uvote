<?php

use App\Livewire\Faq;
use App\Livewire\Voting;
use App\Livewire\HomePage;
use App\Livewire\PastElection;
// use App\Livewire\CompleteProfile;
use App\Livewire\UpcomingElection;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogOutController;
use App\Http\Controllers\StoreVoteController;
use App\Http\Controllers\GoogleAuthController;

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

Route::get('/auth/google', [GoogleAuthController::class, 'signin'])->name('login');
Route::get('/callback', [GoogleAuthController::class, 'callback']);
