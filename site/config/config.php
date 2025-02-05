<?php

return [
    // app
    'url' => env('URL', 'https://kirby.ddev.site'),
    'environment' => env('ENVIRONMENT', 'production'),
    'cache' => [
        'pages' => [
            'active' => env('CACHE', true),
        ],
    ],
    'panel.install' => env('PANEL_INSTALL', true),
    'panel.frameAncestors' => ['self'],
    //languages
    'languages' => env('LANGUAGES', false),
    'languages.detect' => env('LANGUAGES_DETECT', false),
];