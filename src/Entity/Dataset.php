<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:03
 * License MIT
 */

Namespace App\Entity;

/**
 * Class Dataset
 */
class Dataset
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $tempIn;

    /**
     * @var int
     */
    private  $tempOut;

    /**
     * @var int
     */
    private $createDate;

    /**
     * @var int
     */
    private $writeDate;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getTempIn()
    {
        return $this->tempIn;
    }

    /**
     * @param int $tempIn
     */
    public function setTempIn($tempIn)
    {
        $this->tempIn = $tempIn;
    }

    /**
     * @return int
     */
    public function getTempOut()
    {
        return $this->tempOut;
    }

    /**
     * @param int $tempOut
     */
    public function setTempOut($tempOut)
    {
        $this->tempOut = $tempOut;
    }

    /**
     * @return int
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @param int $createDate
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;
    }

    /**
     * @return int
     */
    public function getWriteDate()
    {
        return $this->writeDate;
    }

    /**
     * @param int $writeDate
     */
    public function setWriteDate($writeDate)
    {
        $this->writeDate = $writeDate;
    }
}