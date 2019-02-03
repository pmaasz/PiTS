<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:02
 * License MIT
 */

/**
 * Class ResponseRedirect
 */
class ResponseRedirect implements ResponseInterface
{
    /**
     * @var string
     */
    private $location;

    /**
     * ResponseRedirect constructor.
     *
     * @param $location
     */
    public function __construct($location)
    {
        $this->location = $location;
    }

    /**
     * returns header
     */
    public function send()
    {
        header('Location: '. $this->location);
    }
}