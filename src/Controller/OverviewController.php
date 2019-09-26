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
use App\Service\ExportService;
use App\Service\Templating;
use App\Service\HTTP\Response;

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
     * @var ExportService
     */
    private $exportService;

    /**
     * OverviewController constructor.
     */
    public function __construct()
    {
        $this->datasetRepository = new DatasetRepository();
        $this->exportService = new ExportService();
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

    /**
     * @return bool|Response
     */
    public function downloadAction()
    {
        $datasets = $this->datasetRepository->findAll();

        if ($datasets)
        {
            $fileName = date(ExportService::FILE_FORMAT) . '.csv';

            $this->exportService->export($datasets, $fileName);

            $filePath = ExportService::CSV_DIR;
            $fileSize = filesize($filePath . $fileName);
            $mimeType = 'text/csv';

            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
            header("Content-Type: $mimeType");
            header('Content-Disposition: attachment; filename="'. $fileName .'"');
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . $fileSize);
            readfile($filePath.$fileName);

            return new Response('');
        }

        return new Response('');
    }
}
