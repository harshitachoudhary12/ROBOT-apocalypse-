<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/doc', function () {
    return view('doc');
});

Route::get('/home', function () {
    return view('welcome');
});
Route::get('/api', function () {
    return view('api');
});
Route::get('/','App\Http\Controllers\RobotsController@index');
Route::post('/upload-json-data-db', 'App\Http\Controllers\RobotsController@upload_json_data')->name('upload-json-data-db');
Route::get('/upload-json-data', 'App\Http\Controllers\RobotsController@index')->name('upload-json-data');