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
Route::get('polls', 'PollsController@indexPoll');
Route::get('polls/{id}', 'PollsController@showPoll');
Route::post('polls', 'PollsController@storePoll');
Route::put('polls/{id}','PollsController@updatePoll');
Route::delete('polls/{id}', 'PollsController@deletePoll');
Route::any('errors','PollsController@errors');
Route::apiResource('questions', 'QuestionController');
Route::get('polls/{poll}/questions','PollsController@questions');

