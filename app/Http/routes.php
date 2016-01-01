<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth(); // login(get/post), register(get/post) 등등 지정

    Route::get('/', 'HomeController@index');
    
    
    Route::get('board', 'HomeController@getBoardList');
    Route::get('board/write', 'HomeController@getBoardCreate');
    Route::post('board/write', 'HomeController@postBoardCreate');
    Route::get('board/modify/{id}', 'HomeController@getBoardUpdate');
    Route::post('board/modify/{id}', 'HomeController@postBoardUpdate');
    Route::get('board/delete/{id}', 'HomeController@getBoardDelete');
    Route::post('board/delete/{id}', 'HomeController@postBoardDelete');
    Route::get('board/{id}', 'HomeController@getBoardRead');
});
