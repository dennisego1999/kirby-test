<?php

use Artcoresociety\TranslationsManager\ImportTranslationsAction;
use Illuminate\Validation\ValidationException;

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

            // Instantiate the action class and perform the translation import
            $importAction = new ImportTranslationsAction();
            return $importAction->perform($csvData);
        },
    ],
];
