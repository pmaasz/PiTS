<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 03.02.19
 * Time: 13:01
 * License
 */

$createDate = date('Y-m-d H:i:s');
$sensors = shell_exec('ls /sys/bus/w1/devices');
$sensors = preg_split('/\s+/', $sensors);

foreach($sensors as $key => $sensor)
{
    if($sensor === "w1_bus_master1" || $sensor === "")
    {
        unset($sensors[$key]);
    }
}

$file = 'files/measurement.txt';
$content = uniqid() . ',';

foreach($sensors as $sensor)
{
    $result = shell_exec('cat /sys/bus/w1/devices/' . $sensor . '/w1_slave');

    preg_match('/t=\d+/', $result, $matches);

    $content .= trim($matches[0], 't=') / 1000 . ',';
}

$content .= $createDate . ',';
$writeDate = date('Y-m-d H:i:s');
$content .= $writeDate . ';';

file_put_contents($file, $content, FILE_APPEND);

exit;