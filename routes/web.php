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

Route::get('/', function () {
    return view('welcome');
});

Route::get('polls/export',['uses'=>'PollsController@export', 'as'=>'polls.export']);
Route::resource('polls','PollsController');
Route::post('/editableColumn', ['uses' => 'PollsController@editableColumn', 'as' => 'editableColumn']);