<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:14
 * License
 */

Namespace App\Service;

use App\Driver\CSVDriver;

/**
 * Class ExportService
 *
 * @package App\Service
 */
class ExportService
{
    const CSV_DIR = __DIR__ . '/../../downloads/csv/';
    const FILE_FORMAT = 'Y-m-d_H-i-s_';

    /**
     * @var FileService
     *
     */
    private $filesService;

    /**
     * @var array
     */
    private $exportDrivers = [];

    /**
     * @var CSVDriver
     */
    private $csvDriver;

    /**
     * ExportService constructor.
     *
     */
    public function __construct()
    {
        $this->filesService = new FileService();
        $this->csvDriver = new CSVDriver();
    }

    /**
     * @param $datasets
     * @param $fileName
     */
    public function export($datasets, $fileName)
    {
        //$this->filesService->createDirectory(self::TARGET_DIR.$fileName);
        $this->csvDriver->export($datasets, self::CSV_DIR . $fileName);
        // $this->filesService->deleteDirectory(self::TARGET_DIR.$fileName);
    }

    /**
     * @param $driver
     */
    public function registerDriver($driver)
    {
        $this->exportDrivers[] = $driver;
    }
}