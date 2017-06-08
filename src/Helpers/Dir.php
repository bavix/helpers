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
     * @param bool $recursive
     *
     * @return bool
     */
    public static function remove($path, $recursive = false)
    {
        $path = \rtrim($path, '/') . '/';

        if ($recursive)
        {

            $storage = \array_merge(
                \glob($path . '*'),
                \glob($path . '.*')
            );

            foreach ($storage as $item)
            {

                if (in_array(basename($item), ['.', '..'], true))
                {
                    continue;
                }

                if (static::isDir($item))
                {
                    static::remove($item, $recursive);
                    continue;
                }

                File::remove($item);

            }

        }

        return rmdir($path);
    }

}
