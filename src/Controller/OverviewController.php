<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:05
 * License
 */

Namespace App\Controller;

use App\Service\Templating;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OverviewController
 *
 * @package PiTS\Controller
 */
class OverviewController
{
    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
       return new Response(Templating::getInstance()->render([]));
    }

    public function createAction()
    {

    }

    public function downloadAction()
    {

    }
}