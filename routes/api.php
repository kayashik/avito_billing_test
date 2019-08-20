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
Route::group(['namespace' => 'Api'], function () {
    Route::get('retrieve/{id}',    'GenerateController@retrieve'  )->name('api.retrieve');
    Route::post('generate', 'GenerateController@generate')->name('api.generate');

});
