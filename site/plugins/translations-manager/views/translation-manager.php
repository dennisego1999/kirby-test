<?php

return [
    'pattern' => 'translation-manager',
    'action' => function () {
        return [
            'component' => 'k-translations-view',
            'props' => [
                'translations' => [
                    [
                        'key' => 'test.key',
                        'value' => 'Sleutel',
                    ]
                ],
            ],
        ];
    },
];
