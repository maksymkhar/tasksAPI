<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 2/05/16
 * Time: 16:20
 */

Route::group(['middleware' => ['auth']], function () {
    Route::resource('task', 'TaskController');
    Route::resource('tag', 'TagController');
});

// Public route
Route::get('task/{id}/tag', 'TagController@index');