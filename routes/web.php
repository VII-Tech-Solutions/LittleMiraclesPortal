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

use Illuminate\Support\Facades\Route;

Route::get('/', '\App\API\Controllers\HomeController@welcome');
Route::get('/home', '\App\API\Controllers\HomeController@home');
Route::get('/email', '\App\API\Controllers\HomeController@email');

// usage inside a laravel route
Route::get('/test', '\App\API\Controllers\HomeController@test');
