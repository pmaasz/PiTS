<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:02
 * License MIT
 */

require_once __DIR__ . '/ParameterBag.php';

/**
 * Class Request.
 */
class Request
{
    /**
     * @var ParameterBag
     */
    protected $get;

    /**
     * @var ParameterBag
     */
    protected $post;

    /**
     * @var ParameterBag
     */
    protected $file;

    /**
     * Request constructor.
     *
     * @param array $getData
     * @param array $postData
     * @param array $fileData
     */
    public function __construct(array $getData = array(), array $postData = array(), $fileData = array())
    {
        $this->get = new ParameterBag($getData);
        $this->post = new ParameterBag($postData);
        $this->file = new ParameterBag($fileData);
    }

    /**
     * @return ParameterBag
     */
    public function getGet()
    {
        return $this->get;
    }

    /**
     * @return ParameterBag
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @return ParameterBag
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return bool
     */
    public function isPostRequest()
    {
        return !$this->post->isEmpty();
    }
}