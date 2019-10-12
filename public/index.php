<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:02
 * License MIT
 */

session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use App\Service\HTTP\Response;
use App\Service\ConfigService;

ConfigService::getInstance()->load(__DIR__ . '/../config/config.json');

$controllerName = "OverviewController";
$actionName = "indexAction";

if(isset($_GET['controller']))
{
    $controllerName = $_GET['controller'];
}

if(isset($_GET['action']))
{
    $actionName = $_GET['action'];
}

$request = Request::createFromGlobals();

/** @var mixed $controller */
$controllerName = 'App\\Controller\\' . $controllerName;
/** @var mixed $controller */
$controller = new $controllerName();
/**
 * @var Response $response
 */
$response = $controller->$actionName($request);

$response->send();