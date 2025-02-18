<?php

namespace Artcoresociety\TranslationsManager;

class ImportTranslationsAction
{
    public function perform(array $csvData): void
    {
        // Convert CSV to an array
        $translations = $this->csvToArray($csvData);

        // Loop through the translations and update the values
        foreach ($translations as $translation) {
            dd($translation);
            $this->updateTranslation($translation);
        }
    }

    // Helper function to convert CSV data into an associative array
    private function csvToArray($csvData): array
    {
        $lines = explode("\n", $csvData);
        $header = str_getcsv(array_shift($lines)); // Get header (first row)

        $translations = [];
        foreach ($lines as $line) {
            if (empty($line)) continue; // Skip empty lines
            $row = str_getcsv($line);
            $translations[] = array_combine($header, $row); // Combine header with values
        }

        return $translations;
    }

    // Function to update the translation in Kirby CMS
    private function updateTranslation($translation): void
    {
        // Extract type, key, and locale values
        $type = $translation['TYPE'];
        $key = $translation['KEY'];

        // Loop through each locale and update the corresponding translation
        foreach ($translation as $locale => $value) {
            if (in_array($locale, ['TYPE', 'KEY'])) {
                continue; // Skip TYPE and KEY columns
            }

            // Example: Update translations for a page field or translation file
            // Assuming you have a translation file or page to store the translations:
            $this->saveTranslation($type, $key, $locale, $value);
        }
    }

    // Function to save the translation (could be a page field, file, etc.)
    private function saveTranslation($type, $key, $locale, $value): void
    {
        // You can decide the storage mechanism (e.g., storing in translation files, pages, etc.)
        // Here's a simple example of saving the translation in the Kirby CMS's translation system
        $translationKey = "{$type}.{$key}";

        // Assuming `kirby()->translation()->set()` will update the translation
        kirby()->translations()->set($translationKey, $locale, $value);
    }
}
