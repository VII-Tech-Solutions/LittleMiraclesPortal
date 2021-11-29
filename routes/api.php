<?php

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

/** @var Router $api */

use Dingo\Api\Routing\Router;

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {

    $api->get('/', function () {
        return view('welcome');
    });

    /*******************************
     * API
     *******************************/
    $api->group(['namespace' => 'App\API\Controllers'], function () use ($api) {

        /*******************************
         * Generic
         *******************************/
        $api->get('/data', 'HomeController@data')->middleware('allowed_user:true');

        /*******************************
         * Authentication
         *******************************/
//        $api->post('/login', 'AuthController@login'); // Login

        /*******************************
         * Users
         *******************************/
        $api->post('/users/register', 'UserController@register'); // User Registration

    });

});
