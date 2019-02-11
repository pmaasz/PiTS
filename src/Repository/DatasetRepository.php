<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:18
 * License
 */

Namespace App\Repository;

use App\Entity\Dataset;
use App\Service\Database;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DatasetRepository
 *
 * @package App\Repository
 */
class DatasetRepository
{
    /**
     * @param Dataset $dataset
     *
     * @return mixed
     */
    public function insert(Dataset $dataset)
    {
        return Database::getInstance()->insert("INSERT INTO dataset SET tempIn = :tempIn, tempOut = :tempOut, createDate = :createDate, writeDate = :writeDate",
            [
                'tempIn' => $dataset->getTempIn(),
                'tempOut' => $dataset->getTempOut(),
                'createDate' => $dataset->getCreateDate(),
                'writeDate' => $dataset->getWriteDate(),
            ]);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $result = Database::getInstance()->query("SELECT * FROM dataset SORT BY createDate");
        $datasets = [];

        foreach($result as $data)
        {
            $dataset = $this->arrayToObject($data);
            $datasets[] = $dataset;
        }

        return $datasets;
    }

    /**
     * @param $data
     *
     * @return Dataset
     */
    public function arrayToObject($data)
    {
        $issue = new Dataset();

        $issue->setId($data['id']);
        $issue->setTempIn($data['tempIn']);
        $issue->setTempOut($data['tempOut']);
        $issue->setCreateDate($data['createDate']);
        $issue->setWriteDate($data['writeDate']);

        return $issue;
    }
}