<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 03.02.19
 * Time: 13:01
 * License
 */

function main()
{
    $createDate = date('Y-m-d H:i:s');
    $sensors = [2,4];//getSensors();
    $sensorCount = count($sensors);

    if($sensorCount > 0)
    {
        $content[] = uniqid();
        $content[] = "test1";
        $content[] = "test2";
        //$content = getSensorData($content, $sensors);
        $content[] = $createDate;
        $content[] = date('Y-m-d H:i:s');

        if(\App\Service\Database::getInstance()->isConnected() && false)
        {
            migrateFilesToDatabase('../../files/measurements');

            \App\Service\Database::getInstance()->insert("INSERT INTO pits SET id = :id, temp1 = :temp1, temp2 = :temp2, createDate = :createDate", [
                'id' => $content[0],
                'temp1' => $content[1],
                'temp2' => $content[2],
                'createDate' => $content[3],
            ]);

            return;
        }

        writeToFile($content, $sensorCount);

        return;
    }
}

/**
 * @return array
 */
function getSensors()
{
    $sensors = shell_exec('ls /sys/bus/w1/devices');
    $sensors = preg_split('/\s+/', $sensors);

    foreach($sensors as $key => $sensor)
    {
        if($sensor === "w1_bus_master1" || $sensor === "")
        {
            unset($sensors[$key]);
        }
    }

    return $sensors;
}

/**
 * @param array $content
 * @param array $sensors
 *
 * @return array
 */
function getSensorData(array $content, array $sensors)
{
    foreach($sensors as $key => $sensor)
    {
        $result = shell_exec('cat /sys/bus/w1/devices/' . $sensor . '/w1_slave');

        preg_match('/t=\d+/', $result, $matches);

        $content[] = trim($matches[0], 't=') / 1000;
    }

    return $content;
}

/**
 * @param array $content
 * @param $sensorCount
 *
 * @return false|string
 */
function writeToFile(array $content, $sensorCount)
{
    ob_start();

    $date = date('Y-m-d');
    $file = __DIR__ . '/../files/measurements/measurement' . $date . '.csv';

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
 * @param int $sensorCount
 *
 * @return array
 */
function createFileHeader($sensorCount)
{
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
 * @param string $files
 */
function migrateFilesToDatabase($files)
{
    if (is_dir($files))
    {
        foreach(scandir($files) as $file)
        {
            if ('..' === $file || '.' === $file)
            {
                continue;
            }

            $csvContent = parseCsv($file);

            foreach($csvContent as $content)
            {
                \App\Service\Database::getInstance()->insert("INSERT INTO pits SET id = :id, temp1 = :temp1, temp2 = :temp2, createDate = :createDate", [
                    'id' => $content[0],
                    'temp1' => $content[1],
                    'temp2' => $content[2],
                    'createDate' => $content[3],
                ]);
            }

            deleteFile($file);
        }
    }
}

/**
 * @param $file
 *
 * @return array
 */
function parseCsv($file)
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
function deleteFile($file)
{
    if (is_file($file))
    {
        return unlink($file);
    }

    return false;
}

require __DIR__.'/../vendor/autoload.php';

\App\Service\ConfigService::getInstance()->load(__DIR__ . '/../config/config.json');

main();