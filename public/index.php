<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:02
 * License MIT
 */

session_start();

require_once __DIR__ . '/Service/HTTP/Request.php';
require_once __DIR__ . '/Service/HTTP/Response.php';
require_once __DIR__ . '/Service/HTTP/ResponseRedirect.php';
require_once __DIR__ . '/Service/HTTP/ResponseInterface.php';

ConfigService::getInstance()->load(__DIR__ . 'config.json');

$overviewController = new OverviewController();
$actionName = 'indexAction';

if(isset($_GET['action']))
{
    $actionName = $_GET['action'];
}

$request = new Request($_GET, $_POST);
/**
 * @var ResponseInterface $response
 */
$response = $overviewController->$actionName($request);

$response->send();