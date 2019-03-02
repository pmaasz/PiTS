<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 03.02.19
 * Time: 13:01
 * License
 */

use App\Entity\Dataset;
use App\Repository\DatasetRepository;
use App\Service\ConfigService;

ConfigService::getInstance()->load(__DIR__ . '/../config/config.json');

$sensors = ConfigService::getInstance()->get('sensors');
$tempInRead =  escapeshellcmd('cat /sys/bus/w1/devices/10-000802b4ba0e/w1_slave');
$tempOutRead =  escapeshellcmd('cat /sys/bus/w1/devices/10-000802b4ba0e/w1_slave');
$tempIn = $tempInRead / 1000;
$tempOut = $tempOutRead / 1000;
/*
Wenn alles entsprechend verkabelt ist, können wir das 1-Wire Protokoll damit aktivieren:

sudo modprobe w1-gpio
sudo modprobe w1-therm
Und wir fügen noch eine Zeile hinzu:

sudo nano /boot/config.txt
Dies wird ans Ende gepackt:

dtoverlay=w1-gpio,gpioin=4,pullup=on
Speichere mit STRG+O und schließe mit STRG+X.

Ob es geklappt hat, können wir herausfinden, indem wir folgendes eingeben:

lsmod
Die Module und müssten nun aufgelistet sein, falls nicht wird ein anderer GPIO Pin als 4 benutzt oder es trat ein Fehler beim aktivieren auf.

Damit nicht bei jedem Start die Module geladen werden, tragen wir sie in die Datei /etc/modules ein:

sudo nano /etc/modules
und fügen als letztes die folgenden zwei Zeilen ein:

w1_gpio
w1_therm
Für den nächsten Schritt benötigen wir als erstes die ID des Sensors. Falls du vorhast mehrere in Reihe anzuschließen, teste am besten jeden einzeln und notiere dir die ID, damit du sie später nicht verwechselst.

Wir wechseln das Verzeichnis und geben uns die Dateien aus

cd /sys/bus/w1/devices/
ls
Eine der Dateien heißt 10-000802b4ba0e (bei dir anders) und ist die ID, mit der wir den Sensor abfragen (bitte ID anpassen):

cat /sys/bus/w1/devices/10-000802b4ba0e/w1_slave
In der Ausgabe sehen wir als letzte Angabe die Temperatur (in „Milligrad“)

31 00 4b 46 ff ff 05 10 1c : crc=1c YES
31 00 4b 46 ff ff 05 10 1c t=24437
Durch 1000 geteilt macht das 24.437°C.

Falls eine Fehlermeldung kommt, so musst du wohl bc nachinstallieren.

sudo apt-get install bc
*/
$datasetRepository = new DatasetRepository();
$dataset = new Dataset();

$dataset->setTempIn($tempIn);
$dataset->setTempOut($tempOut);
$dataset->setCreateDate(date('Y-m-d H:i:s'));
$dataset->setWriteDate(date('Y-m-d H:i:s'));
$datasetRepository->insert($dataset);