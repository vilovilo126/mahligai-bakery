<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AI Assistant Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi provider AI untuk Mahligai AI Assistant.
    | API Key hanya dibaca dari environment dan tidak pernah diembarkan ke
    | frontend. Seluruh panggilan AI dilakukan melalui backend Laravel.
    |
    */

    'provider' => env('AI_PROVIDER', 'gemini'),

    'api_key' => env('GEMINI_API_KEY', env('AI_API_KEY')),

    'url' => env('AI_API_URL', 'https://generativelanguage.googleapis.com'),

    'model' => env('AI_MODEL', 'gemini-2.0-flash'),

    'timeout' => (int) env('AI_TIMEOUT', 30),
];
