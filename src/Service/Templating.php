<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:02
 * License MIT
 */

Namespace App\Service;

/**
 * Class Templating
 */
class Templating
{
    use Singleton;

    /**
     * @param $template
     * @param array $parameters
     *
     * @return string
     */
    public function render($template, array $parameters = array())
    {
        ob_start();
        extract($parameters);

        if(!is_dir(__DIR__ . '/../../templates/')){
            include __DIR__ . '/../../templates/' . $template;
        }

        $content = ob_get_clean();

        return $content;
    }
}