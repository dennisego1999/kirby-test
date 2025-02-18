<?php

use Illuminate\Validation\ValidationException;
use Kirby\Cms\Response;

return [
    [
        'pattern' => '/translations-manager/import-translations',
        'method' => 'POST',
        'action' => function () {
            // Ensure the file is uploaded
            if (empty($_FILES['file'])) {
                throw new ValidationException('No file uploaded');
            }

            // Get the uploaded file
            $file = $_FILES['file'];

            // Validate if the uploaded file is a CSV (or other types as needed)
            $allowedTypes = ['text/csv'];
            if (!in_array($file['type'], $allowedTypes)) {
                throw new ValidationException('Invalid file type');
            }

            // Get the file content as a string
            $csvData = file_get_contents($file['tmp_name']); // Read the file content

            // Convert CSV data into an array
            $lines = explode("\n", $csvData);
            $header = str_getcsv(array_shift($lines)); // Get header (first row)

            // Initialize translations array
            $translations = [];
            foreach ($lines as $line) {
                if (empty($line)) continue; // Skip empty lines
                $row = str_getcsv($line);
                $translations[] = array_combine($header, $row); // Combine header with values
            }

            // Loop through the translations and update the values
            foreach ($translations as $translation) {
                $type = $translation['TYPE'];
                $key = $translation['KEY'];

                // Process 'language-variable' type translations
                if ($type === 'language-variable') {
                    foreach ($translation as $locale => $value) {
                        // Skip TYPE and KEY columns
                        if (in_array($locale, ['TYPE', 'KEY'])) {
                            continue;
                        }

                        // Update language-variable translation
                        kirby()->language($locale)->variable($key)->update($value);
                    }
                }

                // Process 'page-field' type translations
                if ($type === 'page-field') {
                    // Assuming the page ID and field name are part of the key (e.g., 'page-id.field-name')
                    foreach ($translation as $locale => $value) {
                        // Skip TYPE and KEY columns
                        if (in_array($locale, ['TYPE', 'KEY'])) {
                            continue;
                        }

                        // Extract page ID and field name from the key
                        $pageId = explode('.', $key)[0]; // Extract the page ID (before the dot)
                        $fieldName = explode('.', $key)[1]; // Extract the field name (after the dot)

                        // Get the page
                        $page = page($pageId);

                        // Check if the page exists and has the specified field
                        if ($page && $page->hasField($fieldName)) {
                            // Update the page field translation
                            $page->update([$fieldName => $value], strtolower($locale));
                        }
                    }
                }
            }

            // Return code 200 on success
            return Response::json([
                'success' => 'Translations successfully imported.',
            ], 200);
        },
    ],
];
