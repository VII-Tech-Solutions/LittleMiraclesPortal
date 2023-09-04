<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'benefit' => [
        'environment' => env('BENEFIT_ENVIRONMENT'),
        'username' => env('BENEFIT_ENVIRONMENT'),
        'institution_id' => env('BENEFIT_INSTITUTION_ID'),
        'merchant_id' => env('BENEFIT_MERCHANT_ID'),
        'tranportal_id' => env('TRANPORTAL_ID'),
        'tranportal_password' => env('TRANPORTAL_PASSWORD'),
        'terminal_resourcekey' => env('TERMINAL_RESOURCEKEY'),
        'payment_secret' => env('PAYMENT_SECRET'),
    ],

    'credimax' => [
        'merchant_id' => env('MERCHANT_ID'),
        'merchant_name' => env('MERCHANT_NAME'),
        'payment_secret' => env('PAYMENT_SECRET'),
    ]
];
