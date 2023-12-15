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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile', [App\Http\Controllers\AccountController::class, 'account'])->name('account');
Route::post('/profile', [App\Http\Controllers\AccountController::class, 'accountPost'])->name('account.post');

Route::group([
    'prefix' => 'applicant',
    'as' => 'applicant.',
    'middleware' => [],
], function(){

    //search job
    //check application status

});

Route::group([
    'prefix' => 'employer',
    'as' => 'employer.',
    'middleware' => [],
], function(){

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
