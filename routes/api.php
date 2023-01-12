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
        $api->post('/chat', 'HomeController@chatMessage')->middleware('allowed_user:true');

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
        $api->get('/firebase-ids', 'UserController@listFirebaseIds');

        /*******************************
         * Questions
         *******************************/
        $api->get('/family-questions', 'MetadataController@listAllFamilyInfoQuestions')->middleware('allowed_user:true'); // List All Family Info Questions
        $api->get('/feedback-questions', 'MetadataController@listAllFeedbackQuestions')->middleware('allowed_user:true'); // List All Feedback Questions

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
        $api->post('/multiple-sessions', 'SessionController@bookMultipleSession')->middleware('allowed_user:true'); // Book Multiple Session
        $api->post('/sessions/{id}/promotion', 'SessionController@applyPromoCode')->middleware('allowed_user:true'); // Apply Promo Code to Session
        $api->post('/sessions/{id}/confirm', 'SessionController@confirm')->middleware('allowed_user:true'); // Confirm the Session
        $api->post('/sessions/{id}/reschedule', 'SessionController@reschedule')->middleware('allowed_user:true'); // Reschedule the Session
        $api->post('/sessions/{id}/review', 'SessionController@submitReview')->middleware('allowed_user:true'); // Submit a Review
        $api->get('/sessions/{id}/guideline', 'SessionController@showGuideline')->middleware('allowed_user:true'); // Show Session Guideline
        $api->post('/sessions/{id}/feedback', 'SessionController@submitFeedback')->middleware('allowed_user:true'); // Submit Session Feedback
        $api->post('/sessions/{id}/appointment', 'SessionController@bookAppointment')->middleware('allowed_user:true');  // Submit the appointment for the session

        /*******************************
         * Gifts
         *******************************/
        $api->get('/gifts', 'GiftController@listAll')->middleware('allowed_user:true'); // List All Gifts
        $api->post('/gifts/claim', 'GiftController@claim')->middleware('allowed_user:true'); // Claim Gift

        /*******************************
         * Profile
         *******************************/
        $api->put('/profile', 'ProfileController@update')->middleware('allowed_user'); // Update profile
        $api->put('/partner', 'ProfileController@updatePartner')->middleware('allowed_user'); // Update partner
        $api->put('/children', 'ProfileController@updateChildren')->middleware('allowed_user'); // Update children
        $api->put('/family', 'ProfileController@updateFamily')->middleware('allowed_user'); // Update family

        /*******************************
         * Studio Packages
         *******************************/
        $api->get('/studio', 'StudioPackageController@listAll')->middleware('allowed_user:true');  // Get Studio Package Info
        $api->get('/studio/{id}', 'StudioPackageController@getInfo')->middleware('allowed_user:true');  // Get Studio Package Info

        /*******************************
         * Cart
         *******************************/
        $api->post('/cart/add', 'CartController@addCartItem')->middleware('allowed_user:true'); // Add Cart Item
        $api->get('/cart', 'CartController@listCartItems')->middleware('allowed_user:true'); // List Cart Items
        $api->delete('/cart/{id}', 'CartController@removeCartItem')->middleware('allowed_user:true'); // Remove Cart Item
        $api->post('/cart/promotion', 'CartController@applyPromoCode')->middleware('allowed_user:true'); // Apply Promo Code
        $api->post('/checkout', 'CartController@checkout')->middleware('allowed_user:true'); // Checkout
        $api->get('/payment/redirect', 'CartController@redirectPayment')->middleware('allowed_user:true'); // Checkout
        $api->get('/payment/process', 'CartController@processCheckout')->middleware('allowed_user:true'); // Checkout

        /*******************************
         * Orders
         *******************************/
        $api->get('/orders', 'CartController@listOrders')->middleware('allowed_user:true'); // List Orders
        $api->post('/benefit/process', '\App\Http\Controllers\BenefitController@process')->middleware('allowed_user:true'); // List Orders
        $api->post('/benefit/approved', '\App\Http\Controllers\BenefitController@approved');
        $api->post('/benefit/declined', '\App\Http\Controllers\BenefitController@declined');
        $api->get('/benefit/error', '\App\Http\Controllers\BenefitController@error');

    });

});
