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
    $sensors = $this->getSensors();
    $sensorCount = count($sensors);

    if($sensorCount > 0)
    {
        $content[] = uniqid();
        $content = $this->getSensorData($content, $sensors);
        $content[] = $createDate;
        $content[] = date('Y-m-d H:i:s');

        if(\App\Service\Database::getInstance()->isConnected())
        {
            \App\Service\Database::getInstance()->insert("INSERT ", $content);

            //$this->migrateFilesToDatabase();

            return;
        }

        $this->writeToFile($content, $sensorCount);

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
 */
function writeToFile(array $content, $sensorCount)
{
    ob_start();

    $date = date('Y-m-d');
    $file = __DIR__ . '/../../files/measurements/measurement' . $date . '.csv';

    if(!is_file($file))
    {
        $header = $this->createFileHeader($sensorCount);
        $csv = fopen($file, 'w');

        fputcsv($csv, $header);
        fputcsv($csv, $content);
    } else {
        $csv = fopen($file, 'a+');

        fputcsv($csv, $content);
    }

    fclose($csv);
    ob_get_clean();
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

function migrateFilesToDatabase()
{
    $file = '';

    $content = $this->readFile($file);

    \App\Service\Database::getInstance()->insert("INSERT ", $content);

    $this->cleanUp();
}

function readFile($file)
{
    $content = [];

    return $content;
}

function cleanUp()
{

}

$this->main();