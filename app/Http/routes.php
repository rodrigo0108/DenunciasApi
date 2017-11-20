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

// Api Controllers
Route::group(['prefix' => 'api/v1'], function(){
	
	Route::post('login', 'Auth\ApiController@login');
	Route::post('register_user', 'Auth\ApiController@register_user');
	Route::get('show_user/{user}', 'Auth\ApiController@show_user');
	Route::resource('denuncias', 'DenunciasController');

});
