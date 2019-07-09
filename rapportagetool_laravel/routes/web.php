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


//Resource routes
Route::resource('posts', 'PostsController');
Route::resource('casefiles', 'CasefilesController');
Route::resource('users', 'UserController');
Route::resource('clients', 'ClientController');
Route::resource('subjects', 'SubjectController');
Route::resource('licenses', 'LicensesController');

//Person info modal calls
Route::get('profile-modal/{category}/{user_id}', 'ModalController@showPersonInfo');

//CheckDelete and Delete routes
Route::get('checkdelete/{category}/{id}', 'CheckDeleteController@checkDelete');
Route::get('delete/{category}/{id}', 'CheckDeleteController@delete');
Route::get('checkrecover/{category}/{id}', 'CheckDeleteController@checkRecover');
Route::get('recover/{category}/{id}', 'CheckDeleteController@recover');

//Route::get('/users', function () {
//    return view('pages.users');
//});

//Route::get('/users/{id}/{name}', function ($id, $name) {
//    return 'this is: ' . $id . ' and name ' . $name;
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//testing
Route::get('/testrandom', 'Services\CasefileNumberGenerator@generateCasefileCode');
Route::get('/testavedarray/{cat}/{id}', 'CavedButtonsController@getCavedBtnArray');
Route::resource('/testarea', 'TestareaController');

//Media displaying
Route::get('/images/profilepicture/{category}/{user_id}/{slug}', 'ImagesController@showUserProfilePicture')->name('UserProfilePicture');


//Ajax
Route::get('/ajaxTestRequest', 'HomeController@ajaxRequest');
Route::post('/ajaxTestRequest', 'HomeController@ajaxRequestPost');
Route::get('/ajaxgetselectlist', 'ModalController@ajaxGetPersonSelectList');

//Approval
Route::get('/approval/{cat}/{id}/{action}', 'ApprovalsController@approval');

Route::post('/ajaxAddPersons/', 'CasefilesController@ajaxAddPersons');