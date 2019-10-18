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

if(count($sensors) > 0)
{
    $date = date('Y-m-d');
    $file = __DIR__ . '/../../files/measurements/measurement' . $date . '.csv';
    $content[] = uniqid();

    foreach($sensors as $key => $sensor)
    {
        $result = shell_exec('cat /sys/bus/w1/devices/' . $sensor . '/w1_slave');

        preg_match('/t=\d+/', $result, $matches);

        $content[] = trim($matches[0], 't=') / 1000;
    }

    $content[] = $createDate;
    $content[] = date('Y-m-d H:i:s');

    ob_start();

    if(!is_file($file))
    {
        $header = [ "ID", "TempIn", "TempOut", "createDate", "writeDate" ];
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
exit;