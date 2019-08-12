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


//Route::get('admin/category/rate','CategoryController@getform')->name('category.rate');
//Route::post('admin/category/saveseller','CategoryController@saveseller');
//Route::get('admin/category/showrate','CategoryController@showrate')->name('category.showrate');
//Route::get('admin/category/getseller','CategoryController@getseller')->name('category.getcategory');
Route::get('admin/category/getseller','SellerController@getseller')->name('seller.getseller');
Route::get('admin/category/getcategory', 'CategoryController@getcategory')->name('category.getcategory');
Route::get('admin/category/getproduct', 'ProductController@getproduct')->name('product.getproduct');
//Route::get('signup','Sign_upController@signup');
//Route::post('signup','Sign_upController@postSignup');
Route::get('admin/category/getcategorymore', 'CategoryController@getcategorymore');
Route::get('admin/category/getsellermore', 'SellerController@getsellermore');
Route::get('admin/product/createwithpost/{post}', 'ProductController@createwitholdpost')->name('product.create.with.oldpost');;
Route::get('admin/product/getphotos', 'ProductController@getphotos');
Route::get('admin/product/getactivefeatured','ProductController@getactivefeatured');
Route::get('admin/product/savefeatured','ProductController@savefeatured');
Route::get('admin/product/getproductmore','ProductController@getproductmore');
Route::get('admin/seller/getsellermore','SellerController@getsellermore');
Route::get('admin/product/getproductdetail','ProductController@getproductdetail');


Route::resource('admin/category','CategoryController');
Route::resource('admin/seller','SellerController');
Route::resource('admin/product','ProductController');
