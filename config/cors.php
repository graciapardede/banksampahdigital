<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure CORS settings to allow cross-domain requests
    | This is important for communication between:
    | - BankSampahDigital (bsdgs.fun / 127.0.0.1:8000)
    | - EcoProvider Service (services.bsdgs.fun / 127.0.0.1:8001)
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        // Local Development
        'http://127.0.0.1:8000',
        'http://localhost:8000',
        'http://127.0.0.1:8001',
        'http://localhost:8001',
        'http://127.0.0.1:3000',
        'http://localhost:3000',
        
        // Production
        'https://bsdgs.fun',
        'https://www.bsdgs.fun',
        'https://services.bsdgs.fun',
        'https://www.services.bsdgs.fun',
    ],

    'allowed_origins_patterns' => [
        // Allow any local environment
        '#^http://127\.0\.0\.\d+:\d+$#',
        '#^http://localhost:\d+$#',
    ],

    'allowed_headers' => [
        '*',
        'Accept',
        'Content-Type',
        'Authorization',
        'X-API-Key',
        'X-API-Secret',
        'X-Requested-With',
        'X-CSRF-TOKEN',
    ],

    'exposed_headers' => [
        'X-Response-Time',
        'X-Total-Count',
        'X-Page-Count',
    ],

    'max_age' => 86400, // 24 hours

    'supports_credentials' => true,

];
