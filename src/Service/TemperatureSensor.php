<?php


namespace App\Service;


class TemperatureSensor
{
    use Singleton;

    /**
     * @return array
     */
    public function getSensors()
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
    public function getSensorData(array $content, array $sensors)
    {
        foreach($sensors as $key => $sensor)
        {
            $result = shell_exec('cat /sys/bus/w1/devices/' . $sensor . '/w1_slave');

            preg_match('/t=\d+/', $result, $matches);

            $content[] = trim($matches[0], 't=');
        }

        return $content;
    }
}