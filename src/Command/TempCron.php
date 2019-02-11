<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 03.02.19
 * Time: 13:01
 * License
 */

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Entity\Dataset;
use App\Repository\DatasetRepository;


/**
 * Class TempCron
 */
class TempCron
{
    /**
     * @var DatasetRepository
     */
    private $datasetRepository;

    /**
     * TempCron constructor.
     */
    public function __construct()
    {
        $this->datasetRepository = new DatasetRepository();
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function createAction(Request $request)
    {
        $dataset = new Dataset();

        $dataset->setTempIn();
        $dataset->setTempOut();
        $dataset->setCreateDate(date('Y-m-d H:i:s'));
        $dataset->setWriteDate(date('Y-m-d H:i:s'));

        return $this->datasetRepository->insert($dataset);
    }
}