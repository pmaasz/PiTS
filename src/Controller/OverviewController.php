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
use App\Service\HTTP\Response;
use App\Driver\CSVDriver;

/**
 * Class OverviewController
 *
 * @package App\Controller
 */
class OverviewController
{
    const CSV_DIR = __DIR__ . '/../../files/csv/';
    const FILE_FORMAT = 'Y-m-d_H-i-s_';

    /**
     * @var DatasetRepository
     */
    private $datasetRepository;

    /**
     * @var CSVDriver
     */
    private $csvDriver;

    /**
     * OverviewController constructor.
     */
    public function __construct()
    {
        $this->datasetRepository = new DatasetRepository();
        $this->csvDriver = new CSVDriver();
    }

    /**
     * @return Response
     */
    public function indexAction()
    {
        $datasets = $this->datasetRepository->getDatasets();

        return new Response(Templating::getInstance()->render('overview.php', [
            'datasets' => $datasets
        ]));
    }

    /**
     * @return Response
     */
    public function downloadAction()
    {
        $datasets = $this->datasetRepository->getDatasets();

        if ($datasets)
        {
            $fileName = date(self::FILE_FORMAT) . '.csv';

            $this->csvDriver->writeNewFile($datasets, self::CSV_DIR . $fileName);

            $fileSize = filesize(self::CSV_DIR . $fileName);
            $mimeType = 'text/csv';

            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false);
            header("Content-Type: $mimeType");
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . $fileSize);
            readfile(self::CSV_DIR . $fileName);

            return new Response('');
        }

        return new Response('');
    }
}
