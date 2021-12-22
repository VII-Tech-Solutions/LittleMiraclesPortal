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
        $api->get('/available-hours', 'HomeController@availableHours')->middleware('allowed_user:true');

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
        $api->get('/questions', 'QuestionController@listAll')->middleware('allowed_user:true'); // List all Questions

        /*******************************
         * Packages
         *******************************/
        $api->get('/packages', 'PackageController@listAll')->middleware('allowed_user:true'); // List all Packages
        $api->get('/packages/{id}', 'PackageController@getInfo')->middleware('allowed_user:true'); // Get Package Info

        /*******************************
         * Sessions
         *******************************/
        $api->get('/sessions', 'SessionController@listAll')->middleware('allowed_user:true'); // List All Sessions
        $api->get('/sessions/{id}', 'SessionController@getInfo')->middleware('allowed_user:true'); // Get Session Info
        $api->post('/sessions', 'SessionController@bookSession')->middleware('allowed_user:true'); // Book a Session
        $api->post('/sessions/{id}/promotion', 'SessionController@applyPromoCode')->middleware('allowed_user:true'); // Apply Promo Code to Session
        $api->post('/sessions/{id}/review', 'SessionController@submitReview')->middleware('allowed_user:true'); // Submit a Review

    });

});
