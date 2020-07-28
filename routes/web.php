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

Route::get('/', 'WorkController@index')->name('home');
Route::post('/addWork', 'WorkController@store')->name('addWord');
Route::put('/changeStatus/{work}', 'WorkController@changeStatus')->name('changeStatus');
Route::delete('/delete/{work}','WorkController@destroy')->name('destroy');

Auth::routes();

