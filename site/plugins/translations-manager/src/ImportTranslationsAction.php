<?php

namespace Artcoresociety\TranslationsManager;

use Kirby\Cms\Response;

class ImportTranslationsAction
{
    /**
     * Perform the translation import action.
     *
     * This method is responsible for orchestrating the whole process of importing
     * translations by first parsing the CSV data and then importing the translations.
     *
     * @param string $csvData The CSV data as a string.
     * @return Response The HTTP response after the import is completed.
     */
    public function perform(string $csvData): Response
    {
        // Parse the CSV data into an array of translations.
        $translations = $this->parseCsv($csvData);

        // Import translations based on the parsed data.
        $this->importTranslations($translations);

        // Return a success response.
        return Response::json([
            'success' => 'Translations successfully imported.',
        ], 200);
    }

    /**
     * Parse the CSV data into an array of translations.
     *
     * This method takes the raw CSV string, splits it into lines, and converts each
     * line into an associative array of translations.
     *
     * @param string $csvData The CSV data as a string.
     * @return array The parsed translations data.
     */
    private function parseCsv(string $csvData): array
    {
        // Split the CSV data into lines.
        $lines = explode("\n", $csvData);

        // Extract the header (first row) to use as keys.
        $header = str_getcsv(array_shift($lines));

        // Initialize an array to hold the translations.
        $translations = [];

        // Loop through each line, skipping empty lines.
        foreach ($lines as $line) {
            if (empty($line)) continue; // Skip empty lines.

            // Combine the header with the row values to form an associative array.
            $row = str_getcsv($line);
            $translations[] = array_combine($header, $row);
        }

        // Return the parsed translations array.
        return $translations;
    }

    /**
     * Import translations into the system.
     *
     * This method processes each translation and imports them based on their type,
     * whether it's a language-variable or page-field type translation.
     *
     * @param array $translations The parsed translations data.
     * @return void
     */
    private function importTranslations(array $translations): void
    {
        // Loop through each translation to process and import.
        foreach ($translations as $translation) {
            $type = $translation['TYPE'];
            $key = $translation['KEY'];

            // Process translations based on their type.
            if ($type === 'language-variable') {
                $this->importLanguageVariable($translation);
            } elseif ($type === 'page-field') {
                $this->importPageField($key, $translation);
            }
        }
    }

    /**
     * Import a language-variable translation.
     *
     * This method imports a language-variable type translation by updating the variable
     * for each locale with the corresponding value.
     *
     * @param array $translation The translation data.
     * @return void
     */
    private function importLanguageVariable(array $translation): void
    {
        // Loop through each locale and update the corresponding variable.
        foreach ($translation as $locale => $value) {
            // Skip TYPE and KEY columns, which are not locale-related.
            if (in_array($locale, ['TYPE', 'KEY'])) continue;

            // Update the language variable for the given locale and key.
            kirby()->language($locale)->variable($translation['KEY'])->update($value);
        }
    }

    /**
     * Import a page-field translation.
     *
     * This method handles translations of type "page-field", where the translation
     * involves updating the field on a specific page.
     *
     * @param string $key The translation key (contains page ID and field name).
     * @param array $translation The translation data.
     * @return void
     */
    private function importPageField(string $key, array $translation): void
    {
        // Extract page ID and field name from the key (e.g., 'page-id.field-name').
        $pageId = explode('.', $key)[0]; // Extract page ID.
        $fieldName = explode('.', $key)[1]; // Extract field name.

        // Loop through each locale and update the page field.
        foreach ($translation as $locale => $value) {
            // Skip TYPE and KEY columns, which are not locale-related.
            if (in_array($locale, ['TYPE', 'KEY'])) continue;

            // Get the page by ID and check if it has the specified field.
            $page = page($pageId);
            if ($page && $page->hasField($fieldName)) {
                // Update the page field translation for the given locale.
                $page->update([$fieldName => $value], strtolower($locale));
            }
        }
    }
}