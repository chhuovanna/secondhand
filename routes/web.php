<?php

use App\Http\Controllers\LanguageController;

/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LanguageController::class, 'swap']);

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */
    include_route_files(__DIR__.'/backend/');
});


Route::get('admin/movie/rate','MovieController@getform')->name('movie.rate');
Route::post('admin/movie/saverating','MovieController@saverating');
Route::get('admin/movie/showrate','MovieController@showrate')->name('movie.showrate');
Route::get('admin/movie/getrating','MovieController@getrating');
Route::get('admin/movie/getmovie', 'MovieController@getmovie')->name('movie.getmovie');

Route::resource('admin/movie','MovieController');
Route::resource('admin/reviewer','ReviewerController');


