<?php

namespace App\Services\HTTP;

use App\Services\HTTP\ResponseInterface;

/**
 * Class Response
 *
 * @package App\Services\HTTP
 */
class Response implements ResponseInterface
{
    /**
     * @var string
     */
    private $content;

    /**
     * Response constructor.
     *
     * @param $content
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     */
    public function send()
    {
        echo $this->content;
    }

    /**
     * @param $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}