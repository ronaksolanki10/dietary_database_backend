<?php

namespace App\Helpers;

/**
 * Class CsvUpload
 * Handles the parsing of CSV files.
 */
class CsvUpload
{
    /**
     * Parse the given CSV file and map its rows according to the expected headers.
     *
     * @param string $file
     * @param array $expectedHeaders
     * @return array
     */
    public static function parse(string $file, array $expectedHeaders): array
    {
        $data = [];

        if (($handle = fopen($file, 'r')) !== false) {
            $header = fgetcsv($handle);

            if ($header !== $expectedHeaders) {
                fclose($handle);
                return [
                    'success' => false,
                    'message' => 'Invalid header, it should contain ' . implode(', ', $expectedHeaders),
                    'data' => []
                ];
            }

            while (($row = fgetcsv($handle)) !== false) {
                $mappedRow = array_combine($expectedHeaders, $row);
                if ($mappedRow !== false) {
                    $data[] = $mappedRow;
                }
            }

            fclose($handle);

            return [
                'success' => true,
                'message' => '',
                'data' => $data
            ];

        } else {
            return [
                'success' => false,
                'message' => 'Unable to open the file',
                'data' => $data
            ];
        }
    }
}