<?php

declare(strict_types=1);

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
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'distance_matrix' => [
        'google' => [
            'key' => env('GOOGLE_DISTANCE_MATRIX_API_KEY'),
            'endpoint' => env('GOOGLE_DISTANCE_MATRIX_ENDPOINT', 'https://maps.googleapis.com/maps/api/distancematrix/json'),
        ],
        'goong' => [
            'key' => env('GOONG_DISTANCE_MATRIX_API_KEY'),
            'endpoint' => env('GOONG_DISTANCE_MATRIX_ENDPOINT', 'https://rsapi.goong.io/DistanceMatrix'),
        ],
    ],

    'vnpay' => [
        'tmnCode' => env('VNP_TMN_CODE'),
        'hashSecret' => env('VNP_HASH_SECRET'),
        'url' => env('VNP_URL'),
        'login_returnUrl' => env('VNP_RETURN_URL_LOGIN'),
        'nonLogin_returnUrl' => env('VNP_RETURN_URL_NOT_LOGIN'),
        'vnpApiUrl' => env('VNP_API_URL'),
        'apiUrl' => env('API_URL'),
        'locale' => env('VNP_LOCALE'),
        'bankCode' => env('VNP_BANKCODE'),
        'version' => env('VNP_VERSION'),
        'currencyCode' => env('VNP_CURRCODE'),
    ],

    'customer_frontend' => [
        'baseUrl' => env('CUSTOMER_FRONTEND_URL', 'https://chanhxemientay.vercel.app'),
        'trackingOrderUrl' => '/tracking',
    ],

    'partner_frontend' => [
        'baseUrl' => env('PARTNER_FRONTEND_URL', 'https://chanhxepartner-k16.vercel.app'),
    ],

    'internal_frontend' => [
        'baseUrl' => env('INTERNAL_FRONTEND_URL', 'https://capstone-project-admin-qqxrc796l-tungvtse.vercel.app'),
    ],
];
