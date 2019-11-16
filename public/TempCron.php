<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 03.02.19
 * Time: 13:01
 * License
 */

require __DIR__ . '/../vendor/autoload.php';

\App\Service\ConfigService::getInstance()->load(__DIR__ . '/../config/config.json');

$createDate = date('Y-m-d H:i:s');
$sensors = \App\Service\TemperatureSensorService::getInstance()->getSensors();
$sensorCount = count($sensors);

if($sensorCount > 0)
{
    $content[] = uniqid();
    $content = \App\Service\TemperatureSensorService::getInstance()->getSensorData($content, $sensors);
    $content[] = $createDate;
    $content[] = date('Y-m-d H:i:s');

    if(\App\Service\Database::getInstance()->isConnected())
    {
        \App\Service\FileService::getInstance()->migrateFilesToDatabase(\App\Service\FileService::FILES_BASE_DIR);
        \App\Service\Database::getInstance()->writeToDatabase($content);

        return;
    }

    \App\Service\FileService::getInstance()->writeToFile($content, $sensorCount);

    return;
}