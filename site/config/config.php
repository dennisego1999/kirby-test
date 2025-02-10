<?php

return [
    // Application Configuration
    // ------------------------

    // Base URL of the site
    'url' => env('APP_URL'),

    // Current environment (production, development, staging)
    'environment' => env('ENVIRONMENT', 'production'),

    // Caching Configuration
    // --------------------
    'cache' => [
        'pages' => [
            // Enable/disable page caching
            'active' => env('CACHE', true),
        ],
    ],

    // Panel Configuration
    // ------------------

    // Allow panel installation
    'panel.install' => env('PANEL_INSTALL', true),

    // Loads custom CSS and JS files for the panel interface
    'ready' => fn () => [
        'panel' => [
            // Load environment-specific and base panel styles
            'css' => vite([
                'site/views/00_panel/panel.scss', // Base panel styles
                'site/views/00_panel/panel-'.option('environment').'.scss', // Environment-specific styles
            ]),
            // Load panel JavaScript
            'js' => vite(['site/views/00_panel/panel.ts']), // Panel functionality
        ],
    ],


    // Language Configuration
    // ---------------------

    // Enable multi-language support
    'languages' => env('LANGUAGES', false),

    // Enable automatic language detection based on browser settings
    'languages.detect' => env('LANGUAGES_DETECT', false),

    // Enable editing of language variables in the panel
    'languages.variables' => env('LANGUAGES_VARIABLES', false),

    // Debug Configuration
    // ------------------

    // Enable debug mode in non-production/staging environments only
    'debug' => ! in_array(env('ENVIRONMENT'), ['production', 'staging']) ? env('DEBUG', false) : false,

    // YAML Configuration
    // ------------------

    // Use Symfony YAML handler (will be default in Kirby 5)
    'yaml.handler' => 'symfony',

    // Image Configuration
    // ------------------

    // Srcset presets for responsive images
    'srcsets' => [
        'default' => [ // JPEG/PNG preset with balanced quality and size
            '400w' => ['width' => 400, 'crop' => true, 'quality' => 90],
            '800w' => ['width' => 800, 'crop' => true, 'quality' => 90], 
            '1200w' => ['width' => 1200, 'crop' => true, 'quality' => 90],
            '1800w' => ['width' => 1800, 'crop' => true, 'quality' => 90],
        ],
        'default-webp' => [ // WebP preset with better compression
            '400w' => ['width' => 400, 'crop' => true, 'quality' => 85, 'format' => 'webp'],
            '800w' => ['width' => 800, 'crop' => true, 'quality' => 85, 'format' => 'webp'],
            '1200w' => ['width' => 1200, 'crop' => true, 'quality' => 85, 'format' => 'webp'],
            '1800w' => ['width' => 1800, 'crop' => true, 'quality' => 85, 'format' => 'webp'],
        ],
        'default-avif' => [ // AVIF preset with highest compression
            '400w' => ['width' => 400, 'crop' => true, 'quality' => 75, 'format' => 'avif'],
            '800w' => ['width' => 800, 'crop' => true, 'quality' => 75, 'format' => 'avif'],
            '1200w' => ['width' => 1200, 'crop' => true, 'quality' => 75, 'format' => 'avif'],
            '1800w' => ['width' => 1800, 'crop' => true, 'quality' => 75, 'format' => 'avif'],
        ],
    ],

    // Image processing configuration
    'driver' => 'im', // Use ImageMagick as the image processing driver better for webp and avif
    'threads' => 2,   // Number of parallel processing threads
];
