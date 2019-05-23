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
//Route::get ('edit','EditcategoryController@editcategory');
//Route::get('delete','DeletecategoryController@deletecategory');
//Route::get('category','CategoryController@category');


Route::get('admin/category/rate','CategoryController@getform')->name('category.rate');
Route::post('admin/category/saveseller','CategoryController@saveseller');
Route::get('admin/category/showrate','CategoryController@showrate')->name('category.showrate');
Route::get('admin/category/getseller','CategoryController@getseller')->name('category.getcategory');
Route::get('admin/category/getseller','SellerController@getseller')->name('seller.getseller');
Route::get('admin/category/getcategory', 'CategoryController@getcategory')->name('category.getcategory');



Route::resource('admin/category','CategoryController');
Route::resource('admin/seller','SellerController');