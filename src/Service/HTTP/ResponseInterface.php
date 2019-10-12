<?php

namespace App\Service\HTTP;

/**
 * Interface ResponseInterface
 *
 * @package App\Service\HTTP
 */
interface ResponseInterface
{
    /**
     * @return mixed
     */
    public function send();
}