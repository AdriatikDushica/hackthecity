<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/{provider}', 'ExternalAuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'ExternalAuthController@handleProviderCallback');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::resource('home', 'HomeController');
    Route::get('create/{location}/next', 'HomeController@createNext');

    Route::post('create/{location}/next', 'HomeController@storeNext');
});

Route::get('locations/{location}', 'HomeController@detail');
Route::get('locations/{location}/like', 'HomeController@like');
Route::post('locations/{location}/comment', 'HomeController@comment');
Route::get('locations/{comment}/delete', 'HomeController@deleteComment');
Route::get('more/{id}', 'HomeController@more');
Route::get('liked', 'HomeController@liked');