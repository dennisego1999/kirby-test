<?php


return [
    // Application Configuration
    // ------------------------
    
    // Base URL of the site
    'url' => env('URL'),
    
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
    
    // Security: Restrict panel iframe embedding to same origin only (for pagepreview plugin)
    'panel.frameAncestors' => ['self'],
    
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
    'debug' => !in_array(env('ENVIRONMENT'), ['production', 'staging']) ? env('DEBUG', false) : false,
    
    // YAML Configuration
    // ------------------
    
    // Use Symfony YAML handler (will be default in Kirby 5)
    'yaml.handler' => 'symfony',
];