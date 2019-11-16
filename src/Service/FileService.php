<?php

namespace App\Service;

/**
 * Class FileService
 */
class FileService
{
    use Singleton;

    /**
     * @param array $content
     * @param $sensorCount
     *
     * @return false|string
     */
    public function writeToFile(array $content, $sensorCount)
    {
        ob_start();

        $date = date('Y-m-d');
        $file = FILES_BASE_DIR . 'measurement' . $date . '.csv';

        if(!is_file($file))
        {
            $header = createFileHeader($sensorCount);
            $csv = fopen($file, 'w');

            fputcsv($csv, $header);
            fputcsv($csv, $content);
        } else {
            $csv = fopen($file, 'a+');

            fputcsv($csv, $content);
        }

        fclose($csv);

        return ob_get_clean();
    }

    /**
     * @param string $files
     */
    public function migrateFilesToDatabase($files)
    {
        if (is_dir($files))
        {
            foreach(scandir($files) as $file)
            {
                if ('..' === $file || '.' === $file)
                {
                    continue;
                }

                $csvContent = parseCsv(FILES_BASE_DIR . $file);

                foreach($csvContent as $content)
                {
                    writeToDatabase($content);
                }

                deleteFile($file);
            }
        }
    }

    /**
     * @param int $sensorCount
     *
     * @return array
     */
    private function createFileHeader($sensorCount)
    {
        /** @todo move parts of file header into const array, slow transition */

        $header[] =  "ID";

        for($i = 0; $i < $sensorCount; $i++)
        {
            $header[] = "Temp" . $i;
        }

        $header[] = "createDate";
        $header[] = "writeDate";

        return $header;
    }

    /**
     * @param $file
     *
     * @return array
     */
    private function parseCsv($file)
    {
        $content = utf8_encode(file_get_contents($file));
        $dataRows = explode("\n", $content);
        $result = [];
        array_shift($dataRows);

        foreach ($dataRows as $key => $dataRow)
        {
            if ('' === trim($dataRow))
            {
                continue;
            }

            $result[] = str_getcsv($dataRow, ',', '"');
        }

        return $result;
    }

    /**
     * @param $file
     *
     * @return bool
     */
    private function deleteFile($file)
    {
        if (is_file($file))
        {
            return unlink($file);
        }

        return false;
    }
}