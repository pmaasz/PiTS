<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:02
 * License MIT
 */

/**
 * Interface ResponseInterface.
 */
interface ResponseInterface
{
    /**
     * @return mixed
     */
    public function send();
}