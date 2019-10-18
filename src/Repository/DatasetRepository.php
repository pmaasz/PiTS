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
        $result = Database::getInstance()->query("SELECT * FROM dataset");
        $datasets = [];

        foreach($result as $data)
        {
            $dataset = $this->arrayToObject($data);
            $datasets[] = $dataset;
        }

        return $datasets;
    }

    /**
     * @return array
     */
    public function getDatasets()
    {
        $measurement = '/var/www/PiTS/files/measurements/measurement.csv';
        $id = uniqid();
        $view = '/var/www/PiTS/files/temp/view/view' . $id . '.txt';

        shell_exec('cp ' . $measurement . ' ' . $view);

        $measurement = fopen($view, 'r');
        $results = explode(';', $measurement);
        $datasets = [];

        foreach($results as $result)
        {
            $data = explode(',', $result);
            $dataset = new Dataset();

            $dataset->setId($data[0]);
            $dataset->setTempIn($data[1]);
            $dataset->setTempOut($data[2]);
            $dataset->setCreateDate($data[3]);
            $dataset->setWriteDate($data[4]);

            $datasets[] = $dataset;
        }

        shell_exec('rm -rf ' . $view);

        return $datasets;
    }

    /**
     * @param $data
     *
     * @return Dataset
     */
    private function arrayToObject($data)
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