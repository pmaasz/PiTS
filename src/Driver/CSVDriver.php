<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:15
 * License
 */

Namespace App\Driver;

/**
 * Class CSVDriver
 *
 * @package App\Driver
 */
class CSVDriver
{
    /**
     * @param $export
     * @param $filePath
     */
    public function writeNewFile($export, $filePath)
    {
        ob_start();

        $header = [
            "ID",
            "TempIn",
            "TempOut",
            "createDate",
            "writeDate",
        ];
        $csv = fopen($filePath, 'w');

        fputcsv($csv, $header);

        foreach ($export as $entry)
        {
            fputcsv($csv, (array)$entry);
        }

        fclose($csv);
        ob_get_clean();
    }

    /**
     * @param array $newLine
     * @param string $filePath
     */
    public function writeNewLine(array $newLine, $filePath)
    {
        ob_start();

        $csv = fopen($filePath, 'w');

        fputcsv($csv, $newLine);
        fclose($csv);
        ob_get_clean();
    }

}