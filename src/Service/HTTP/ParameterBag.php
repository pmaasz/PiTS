<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:02
 * License MIT
 */

/**
 * Class ParameterBag
 */
class ParameterBag
{
    /**
     * @var array
     */
    private $elements;

    /**
     * ParameterBag constructor.
     *
     * @param array $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * @param string $key
     *
     * @return mixed
     *
     * @throws \UnexpectedValueException
     */
    public function get($key)
    {
        if(!$this->hasKey($key))
        {
            return false;
        }

        return $this->elements[$key];
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function hasKey($key)
    {
        return isset($this->elements[$key]);
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return empty($this->elements);
    }
}
