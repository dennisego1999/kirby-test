<?php

return [
    'pattern' => 'translation-manager',
    'action' => function () {
        return [
            'component' => 'k-translations-view',
            'props' => [
                'translations' => ['test'],
            ],
        ];
    },
];
