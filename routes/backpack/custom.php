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
    Route::crud('cake-categories', 'CakeCategoryCrudController');
    Route::crud('backdrops', 'BackdropCrudController');
    Route::crud('backdrop-categories', 'BackdropCategoryCrudController');
    Route::crud('daily-tips', 'DailyTipCrudController');
    Route::crud('promotions', 'PromotionCrudController');
    Route::crud('gifts', 'GiftCrudController');
    Route::get('gifts/{id}/activate', 'GiftCrudController@activate');
    Route::get('gifts/{id}/de-activate', 'GiftCrudController@deActivate');

    Route::crud('workshops', 'WorkshopCrudController');
    Route::crud('reviews', 'ReviewCrudController');
    Route::crud('sessions', 'SessionCrudController');
    Route::crud('faqs', 'FaqsCrudController');
    Route::crud('pages', 'PageCrudController');
    Route::crud('social-media', 'SocialMediaCrudController');
    Route::crud('sections', 'SectionCrudController');
    Route::crud('users', 'UserCrudController');
    Route::crud('studio-metadata', 'StudioMetadataCrudController');
    Route::crud('family-members', 'FamilyMemberCrudController');
    Route::crud('family-info', 'FamilyInfoCrudController');
    Route::crud('family-info-questions', 'FamilyInfoQuestionCrudController');
    Route::crud('tags', 'TagCrudController');
    Route::crud('benefits', 'BenefitCrudController');
    Route::crud('studio-packages', 'StudioPackageCrudController');
    Route::crud('packages', 'PackageCrudController');
    Route::crud('sub-packages', 'SubPackageCrudController');
    Route::crud('feedback', 'FeedbackCrudController');
    Route::crud('feedback-questions', 'FeedbackQuestionCrudController');
    Route::crud('user-studio', 'UserStudioCrudController');
    Route::crud('user-studio-specs', 'UserStudioSpecsCrudController');
    Route::crud('payment-method', 'PaymentMethodCrudController');
    Route::crud('available-dates', 'AvailableDateCrudController');
}); // this should be the absolute last line of this file
