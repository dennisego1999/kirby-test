<?php

namespace Artcoresociety\TranslationsManager;

class Translations
{
    public static function getAllTranslations(): array
    {
        // Set array
        $translations = [];

        // Define the page fields to ignore
        $ignorePageFields = [
            'uuid',
            'blocks'
        ];

        // Fetch all site translations
        foreach (kirby()->languages() as $language) {
            // Fetch language variables
            foreach ($language->translations() as $key => $value) {
                $translations[] = [
                    'type' => 'language-variable',
                    'key' => $key,
                    'value' => $value,
                    'locale' => $language->code(),
                ];
            }
        }

        // Fetch content fields in all languages
        foreach (site()->index() as $page) {
            foreach (kirby()->languages() as $language) {
                foreach ($page->content($language->code())->data() as $fieldKey => $fieldValue) {
                    // Skip ignored fields
                    if (in_array($fieldKey, $ignorePageFields)) {
                        continue;
                    }

                    $translations[] = [
                        'type' => 'page-field',
                        'key' => $page->id() . '.' . $fieldKey,
                        'value' => $fieldValue,
                        'locale' => $language->code(),
                    ];
                }
            }
        }

        return $translations;
    }
}