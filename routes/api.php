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
        $api->post('/login', 'AuthenticationController@socialLogin')->middleware('allowed_user:true'); // Social Login
        $api->post('/register', 'AuthenticationController@register')->middleware('allowed_user:true'); // Registration

        /*******************************
         * Users
         *******************************/
        $api->post('/users/register', 'UserController@register'); // User Registration
        $api->delete('/delete-account', 'UserController@delete')->middleware('allowed_user:true');


        /*******************************
         * Questions
         *******************************/
        $api->get('/questions', 'QuestionController@listAll')->middleware('allowed_user:true'); // List all questions

    });

});
