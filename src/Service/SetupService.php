<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 16.02.19
 * Time: 00:06
 * License
 */

namespace App\Service;


class SetupService
{
    /**
     * @var array
     */
    private $sensors;

    public function findSensors()
    {

    }

    public function mountSensors()
    {

    }

    public function activateOneWire()
    {
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
*/
    }
}