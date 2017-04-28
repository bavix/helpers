<?php

namespace Bavix\Helpers;

class Dir
{

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function make($path)
    {
        return is_dir($path) || @mkdir($path, 0777, true);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function isDir($path)
    {
        return is_dir($path);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function remove($path)
    {
        return rmdir($path);
    }

}
