<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:02
 * License MIT
 */

require_once __DIR__ . '/ResponseInterface.php';

/**
 * Class Response
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
     * This function echoes content as string to browser which is interpreted by the browser.
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