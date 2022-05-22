<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('add-survivor', 'App\Http\Controllers\SurvivorsController@add_survivors')->name('add-survivor');
Route::post('update-location', 'App\Http\Controllers\SurvivorsController@update_location')->name('update-location');
Route::post('report-infected-person', 'App\Http\Controllers\SurvivorsController@infected_report')->name('report-infected-person');
Route::get('report-robots', 'App\Http\Controllers\RobotsController@robots_report')->name('report-robots');