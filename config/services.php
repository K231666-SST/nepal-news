<?php
// config/services.php

return [
    'mailgun'  => ['domain' => env('MAILGUN_DOMAIN'), 'secret' => env('MAILGUN_SECRET'), 'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'), 'scheme' => 'https'],
    'postmark' => ['token'  => env('POSTMARK_TOKEN')],
    'ses'      => ['key' => env('AWS_ACCESS_KEY_ID'), 'secret' => env('AWS_SECRET_ACCESS_KEY'), 'region' => env('AWS_DEFAULT_REGION', 'us-east-1')],

    // ── Live API Keys ─────────────────────────────────────────
    'weather' => [
        'key' => env('WEATHER_API_KEY'),
        // Get free key at: openweathermap.org/api (60 calls/min free)
    ],
    'metal' => [
        'key' => env('METAL_API_KEY'),
        // Get free key at: metalpriceapi.com (100 calls/month free)
    ],
    'openai' => [
        'key' => env('OPENAI_API_KEY'),
        // Get key at: platform.openai.com/api-keys
    ],
    // Note: ExchangeRate-API and Horoscope API are free with no key needed

    'openai' => [
        'key' => env('OPENAI_API_KEY'),
    ],

    'groq' => [
        'key' => env('GROQ_API_KEY'),
    ],
];

