<?php

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

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');

Route::get('/permissions/{permissionRequired}', 'PermissionsController@getBitwiseValue');

Route::get('/permissions/getvalue/{permissionName}', 'PermissionsController@getBitwiseValue');

//Resource routes
Route::resource('posts', 'PostsController');
Route::resource('casefiles', 'CasefilesController');
Route::resource('clients', 'ClientController');
Route::resource('users', 'UserController');

//Route::get('/users', function () {
//    return view('pages.users');
//});

//Route::get('/users/{id}/{name}', function ($id, $name) {
//    return 'this is: ' . $id . ' and name ' . $name;
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//testing
Route::get('/testpermissionsvalue', 'PermissionsController@testBitwiseValue');
Route::get('/testrandom', 'Services\CasefileNumberGenerator@generateCasefileCode');