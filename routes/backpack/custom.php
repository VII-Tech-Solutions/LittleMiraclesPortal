<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('notifications', 'NotificationCrudController');
    Route::crud('onboardings', 'OnboardingCrudController');
    Route::crud('photographers', 'PhotographerCrudController');
    Route::crud('cakes', 'CakeCrudController');
    Route::crud('backdrops', 'BackdropCrudController');
    Route::crud('daily-tips', 'DailyTipCrudController');
    Route::crud('promotions', 'PromotionCrudController');
    Route::crud('workshops', 'WorkshopCrudController');
    Route::crud('reviews', 'ReviewCrudController');
    Route::crud('sessions', 'SessionCrudController');
    Route::crud('faqs', 'FaqsCrudController');
    Route::crud('pages', 'PageCrudController');
    Route::crud('session-package', 'SessionPackageCrudController');
    Route::crud('social-media', 'SocialMediaCrudController');
    Route::crud('sections', 'SectionCrudController');
    Route::crud('users', 'UserCrudController');

}); // this should be the absolute last line of this file
