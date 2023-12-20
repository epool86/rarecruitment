<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test/dashboard', function () {
    return view('dashboard');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function(){

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [App\Http\Controllers\AccountController::class, 'account'])->name('account');
    Route::post('/profile', [App\Http\Controllers\AccountController::class, 'accountPost'])->name('account.post');

    Route::group([
        'prefix' => 'applicant',
        'as' => 'applicant.',
        'middleware' => [],
    ], function(){

        Route::get('/job/search', [App\Http\Controllers\Applicant\JobController::class, 'search'])->name('search');
        Route::get('/job/history', [App\Http\Controllers\Applicant\ApplicationController::class, 'index'])->name('history');
        Route::post('/job/apply', [App\Http\Controllers\Applicant\ApplicationController::class, 'store'])->name('application.store');
        Route::get('/resume', [App\Http\Controllers\Applicant\ResumeController::class, 'resumeShow'])->name('resume.show');
        Route::get('/resume/edit', [App\Http\Controllers\Applicant\ResumeController::class, 'resumeEdit'])->name('resume.edit');
        Route::post('/resume/edit', [App\Http\Controllers\Applicant\ResumeController::class, 'resumePost'])->name('resume.post');

    });

    Route::group([
        'prefix' => 'employer',
        'as' => 'employer.',
        'middleware' => ['employer'],
    ], function(){

        Route::resource('application', 'App\Http\Controllers\Employer\ApplicationController');
        Route::resource('job', 'App\Http\Controllers\Employer\JobController');

    });

    Route::group([
        'prefix' => 'admin',
        'as' => 'admin.',
        'middleware' => [],
    ], function(){

        //manage applicant
        //manage employer
        //manage jobs

    });

});
