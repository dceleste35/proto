<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Resend, Postmark, AWS, and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // Génération PDF (Browsershot / Chrome headless) pour les affiches vitrine.
    'browsershot' => [
        'node' => env('BROWSERSHOT_NODE_BINARY', '/opt/homebrew/bin/node'),
        'chrome' => env('BROWSERSHOT_CHROME_PATH', '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome'),
    ],

    // Source des biens. driver=fixture (démo) | agiprint (base partagée, comme qr-switch) | api (SDK SweepBright).
    'sweepbright' => [
        'driver' => env('PROPERTY_SOURCE', 'fixture'),
        'table' => env('SWEEPBRIGHT_TABLE', 'estates'),
        'base_url' => env('SWEEPBRIGHT_BASE_URL'),
        'api_version' => env('SWEEPBRIGHT_API_VERSION'),
        'client_id' => env('SWEEPBRIGHT_CLIENT_ID'),
        'client_secret' => env('SWEEPBRIGHT_CLIENT_SECRET'),
    ],

    // Source des conseillers/agences. driver=fixture (démo, défaut) | api (Télémaque réel).
    'telemaque' => [
        'driver' => env('ADVISOR_SOURCE', 'fixture'),
        'base_url' => env('TELEMAQUE_BASE_URL'),
        'api_version' => env('TELEMAQUE_API_VERSION'),
        'token' => env('TELEMAQUE_TOKEN'),
    ],

];
