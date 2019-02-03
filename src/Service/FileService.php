<?php
/**
 * Created by PhpStorm.
 * Author: Philip Maaß
 * Date: 07.01.19
 * Time: 20:14
 * License
 */

class FileService
{
    /**
     * @param string $path
     * @param bool   $isFile
     *
     * @return string
     */
    public function createDirectory($path, $isFile = false)
    {
        if ($isFile)
        {
            $path = dirname($path);
        }

        if (!is_dir($path))
        {
            mkdir($path, 0777, true);
        }

        return $path;
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public function deleteFile($path)
    {
        if (is_file($path))
        {
            return unlink($path);
        }

        return false;
    }

    /**
     * @param $path
     *
     * @return bool
     */
    public function deleteDirectory($path)
    {
        if (is_dir($path))
        {
            foreach (scandir($path) as $item)
            {
                if ('..' === $item || '.' === $item)
                {
                    continue;
                }

                $this->deleteFile($path.'/'.$item);
            }

            return rmdir($path);
        }

        return false;
    }
}