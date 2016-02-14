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

Route::get('/', 'StoryController@index');

Route::get('stories', 'StoryController@index');

Route::get('story/create', 'StoryController@create');

Route::get('story/{id}', 'StoryController@show');

Route::post('story/store', 'StoryController@store');

Route::get('story/{id}/edit', 'StoryController@edit');

Route::patch('story/{id}/update', 'StoryController@update');

Route::get('story/{id}/destroy', 'StoryController@destroy');

Route::post('story/addComment', 'StoryController@addComment');

Route::get('my/stories', 'StoryController@myStories');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
