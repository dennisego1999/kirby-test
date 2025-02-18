<?php

Kirby::plugin('artcoresociety/translation-manager', [
    'areas' => [
        'translation-manager' => function ($kirby) {
            return [
                'label' => 'Translation Manager',
                'icon' => 'bug',
                'menu' => true,
                'link' => 'translation-manager',
                'views' => [
                    require __DIR__.'/views/translation-manager.php',
                ],
            ];
        },
    ],
]);