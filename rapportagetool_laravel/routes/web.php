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

use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');


//Resource routes
Route::resource('posts', 'PostsController');
Route::get('/casefiles/cc/{casecode}', 'CasefilesController@showByCasecode');
Route::resource('casefiles', 'CasefilesController');
Route::post('/generateregkey',[
    'as' => 'generateregkey',
    'uses' => 'UserController@generateRegkey'
]);
Route::resource('users', 'UserController');
Route::resource('clients', 'ClientController');
Route::resource('subjects', 'SubjectController');
Route::resource('licenses', 'LicensesController');
Route::resource('messages', 'MessagesController');
Route::resource('casenotes', 'CasenotesController');

//Person info modal calls
Route::get('profile-modal/{category}/{user_id}', 'ModalController@showPersonInfo');

//CheckDelete and Delete routes
Route::get('checkdelete/{category}/{id}', 'CheckDeleteController@checkDelete');
Route::get('delete/{category}/{id}', 'CheckDeleteController@delete');
Route::get('checkrecover/{category}/{id}', 'CheckDeleteController@checkRecover');
Route::get('recover/{category}/{id}', 'CheckDeleteController@recover');
Route::get('checkerase/{category}/{id}', 'CheckDeleteController@checkErase');


//Autosave
Route::post('ajaxautosave/{category}/{id}', 'AutosavesController@saveFromAjax');
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
Route::get('/inputbox', function(){return view('includes.components.searchbox');});

//Media displaying
Route::get('/images/profilepicture/{category}/{user_id}/{slug}', 'ImagesController@showUserProfilePicture')->name('UserProfilePicture');


//Ajax
Route::get('/ajaxTestRequest', 'HomeController@ajaxRequest');
Route::post('/ajaxTestRequest', 'HomeController@ajaxRequestPost');
Route::get('/ajaxgetselectlist', 'ModalController@ajaxGetPersonSelectList');
Route::post('/ajaxdynamicsearch', 'DynamicSearchController@getSearchItems');
Route::post('/ajaxdynamicsearch/addtolist', 'DynamicSearchController@addToList');
Route::get('/ajaxdynamicsearch/receivelist', 'DynamicSearchController@receiveList');



//Approval
Route::get('/approval/{cat}/{id}/{action}', 'ApprovalsController@approval');

Route::post('/ajaxAddPersons/', 'CasefilesController@ajaxAddPersons');

//PDF
Route::get('/generate-test-pdf','HomeController@generatePDF');
Route::get('/to-pdf/{category}/{id}','PdfController@toPdf');

//passport
Route::get('/passport-manager','HomeController@passportManager');


//AXIOS (internal API/JSON calls)
//Generics
Route::post('/axios/get-dropdown-values', 'Axios\DropdownController@getValues');
Route::post('/axios/update-dropdown-value', 'Axios\DropdownController@updateValue');
Route::post('/axios/get-linklist-values', 'Axios\LinklistController@getValues');
Route::post('/axios/get-search-values', 'Axios\DynamicSearchController@getSearchValues');
Route::post('/axios/add-to-list', 'Axios\DynamicSearchController@addToList');
Route::post('/axios/remove-from-list', 'Axios\DynamicSearchController@removeFromList');
Route::post('/axios/get-objects-list', 'Axios\DynamicSearchController@receiveList');