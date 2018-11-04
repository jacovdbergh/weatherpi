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

Route::get('/', 'WeatherDataController@index');
Route::get('/data-updated', 'WeatherDataController@weatherDataUpdated');
Route::get('/take-reading', 'WeatherDataController@takeReading');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
