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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::get('/locations', function()
{
    return \App\Location::whereNotNull('type_id')->get(['id', 'path', 'lat', 'lng']);
});

Route::get('/locations/{id}', function($id)
{
    return \App\Location::with('user')->where('id', '=', $id)->first();
});