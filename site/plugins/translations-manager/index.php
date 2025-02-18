<?php

Kirby::plugin('artcoresociety/translations-manager', [
    'areas' => [
        'translations-manager' => function ($kirby) {
            return [
                'label' => 'Translations Manager',
                'icon' => 'bug',
                'menu' => true,
                'link' => 'translations-manager',
                'views' => [
                    require __DIR__.'/views/translations-manager.php',
                ],
            ];
        },
    ],
]);