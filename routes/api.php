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

/*******************************
 * API
 *******************************/
/** @var Router $api */

use Dingo\Api\Routing\Router;
use VIITech\Helpers\GlobalHelpers;

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->get('/', function () {
        return ['status' => true];
    });

    // Sentry
    if(!GlobalHelpers::isProductionEnv()) {
        $api->get('/debug-sentry', function () {
            throw new Exception('My first Sentry error!');
        });
    }

    $api->group(['namespace' => 'App\API\Controllers'], function () use ($api) {

        /*******************************
         * Registration
         *******************************/
        $api->post('/login', 'AuthenticationController@authenticate')->middleware('allowed_user:true'); // Login

    });
});
