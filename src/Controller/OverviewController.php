<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:05
 * License
 */

Namespace App\Controller;

use App\Repository\DatasetRepository;
use App\Service\Templating;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OverviewController
 *
 * @package App\Controller
 */
class OverviewController
{
    /**
     * @var DatasetRepository
     */
    private $datasetRepository;

    /**
     * OverviewController constructor.
     */
    public function __construct()
    {
        $this->datasetRepository = new DatasetRepository();
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $datasets = $this->datasetRepository->findAll();

        return new Response(Templating::getInstance()->render('overview.php', [
            'datasets' => $datasets
        ]));
    }

    public function createAction(Request $request)
    {

    }

    public function downloadAction(Request $request)
    {

    }
}