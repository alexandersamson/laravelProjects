<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('casenote/{id}', 'CasenotesController@showApi'); //A single casenote
Route::get('casenotes/{id}', 'CasenotesController@showCasefileNotesApi'); //All casenotes belonging to a case
Route::get('casenotes', 'CasenotesController@indexApi'); //All casenotes