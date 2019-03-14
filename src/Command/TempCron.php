<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 03.02.19
 * Time: 13:01
 * License
 */

require_once __DIR__ . '/../../vendor/autoload.php';

use App\Service\ConfigService;

ConfigService::getInstance()->load(__DIR__ . '/../../config/config.json');

$parameters = [
    "createDate" => date('Y-m-d H:i:s'),
];
$sensors = ConfigService::getInstance()->get('sensors');
$parameters['tempIn'] = escapeshellcmd('cat /sys/bus/w1/devices/' . $sensors['temp1'] . '/w1_slave') / 1000;
$parameters['tempOut'] = escapeshellcmd('cat /sys/bus/w1/devices/' . $sensors['temp2'] . '/w1_slave') / 1000;
$config = ConfigService::getInstance()->get('database');
$connection = new PDO(sprintf("%s:host=%s;dbname=%s", $config['driver'], $config['host'], $config['dbname']), $config['user'], $config['password']);
$query = "INSERT INTO dataset SET tempIn = :tempIn, tempOut = :tempOut, createDate = :createDate, writeDate = :writeDate";
$statement = $connection->prepare($query);

$parameters['writeDate'] = date('Y-m-d H:i:s');

foreach($parameters as $key => $value)
{
    $statement->bindValue(':' . $key, $value);
}

$statement->execute();