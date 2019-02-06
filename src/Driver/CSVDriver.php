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
 * @package PiTS\Driver
 */
class CSVDriver
{
    /**
     * @param $export
     * @param $filePath
     */
    public function export($export, $filePath)
    {
        ob_start();

        $header = array(
            "EventID",
            "Timestamp",
            "IssueID",
            "Label Name",
            "Source",
            "Target",
            "Event",
        );
        $csv = fopen($filePath, 'w');

        fputcsv($csv, $header);

        foreach ($export as $entry)
        {
            fputcsv($csv, (array)$entry);
        }

        fclose($csv);
        ob_get_clean();
    }
}