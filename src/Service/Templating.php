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
     * @param array $parameters
     *
     * @return string
     */
    public function render(array $parameters = array())
    {
        ob_start();
        extract($parameters);

        $content = __DIR__ . '/../templates/index.php';
        $content = ob_get_clean();

        return $content;
    }
}