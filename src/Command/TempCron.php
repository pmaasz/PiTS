<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 03.02.19
 * Time: 13:01
 * License
 */

$createDate = date('Y-m-d H:i:s');
$sensors = escapeshellcmd('ls /sys/bus/w1/devices/'); //ConfigService::getInstance()->get('sensors');
$sensors = explode('', $sensors);
$therms = array();

foreach($sensors as $key => $sensor)
{
    $therms['therm'.$key] = $sensor;
}
/**
 * TODO sensoren sortieren
 */


$file = fopen(__DIR__ . '/files/temp/measurement', 'a+');

foreach($therms as $key => $sensor)
{
    $parameters['tmp' . $key] = escapeshellcmd('cat /sys/bus/w1/devices/' . $sensor . '/w1_slave') / 1000;
}

/**
 * TODO Datei schreiben
 */
$content = '';
$content .= $createDate . ',';
$writeDate = date('Y-m-d H:i:s');
$content .= $writeDate . ';';

fwrite($file, $content);
fclose($file);

exit;