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

Route::prefix('/v1')->namespace('Api\v1')->group(function(){

    Route::group(['middleware' => ['guest:api']], function () {
        Route::post('login', 'AuthController@login');
        Route::post('signup', 'AuthController@signup');
    });

    Route::group(['middleware' => 'auth:api'], function() {
        Route::post('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');

        Route::get('work','WorkController@index');
        Route::post('work','WorkController@store');
        Route::put('changeStatus/{work}', 'WorkController@changeStatus');
        Route::delete('work/{work}','WorkController@destroy');
    });

});