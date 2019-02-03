<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:02
 * License MIT
 */

/**
 * Trait Singleton
 */
trait Singleton
{
    /**
     * @var mixed
     */
    protected static $instance;

    /**
     * Singleton constructor.
     */
    protected function __construct()
    {
    }

    /**
     * clones Object we want to use when calling the instance
     */
    protected function __clone()
    {
    }

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if( ! self::$instance )
        {
            self::$instance = new self();
        }

        return self::$instance;
    }
}