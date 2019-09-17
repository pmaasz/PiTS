<?php

namespace App\Services\HTTP;

/**
 * Interface ResponseInterface
 *
 * @package App\Services\HTTP
 */
interface ResponseInterface
{
    /**
     * @return mixed
     */
    public function send();
}