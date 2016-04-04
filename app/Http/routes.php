<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});




// TODO: 'resource' DEPRECATED!
Route::group(['middleware' => 'auth:api'], function () {

    Route::resource('task', 'TaskController');
    Route::resource('tag', 'TagController');
    Route::get('task/{id}/tag', 'TagController@index');
});

Route::get('/auth/login', function () {
    return "No authoritzed!!";
});

//Route::resource('task.tag', 'TaskTagController');