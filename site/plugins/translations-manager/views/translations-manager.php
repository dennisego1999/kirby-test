<?php

use Artcoresociety\TranslationsManager\Translations;

return [
    'pattern' => 'translations-manager',
    'action' => function () {
        return [
            'component' => 'k-translations-view',
            'props' => [
                'translations' => Translations::getAllTranslations(),
            ],
        ];
    },
];
