<?php

namespace Bavix\Helpers;

class File
{

    /**
     * @param string $filename
     * @param mixed  $contents
     *
     * @return bool|int
     */
    public static function put($filename, $contents)
    {
        return \file_put_contents($filename, $contents);
    }

    /**
     * @param string $source
     * @param string $mode
     *
     * @return bool|resource
     */
    public static function open($source, $mode = 'r')
    {
        return @fopen($source, $mode . 'b');
    }

    /**
     * @param resource $handle
     *
     * @return bool
     */
    public static function close($handle)
    {
        return \fclose($handle);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function touch($path)
    {
        return @touch($path);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function remove($path)
    {
        return \unlink($path);
    }

    /**
     * @param string $path
     *
     * @return int
     */
    public static function size($path)
    {
        return \filesize($path);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function isReadable($path)
    {
        return \is_readable($path);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function isFile($path)
    {
        return \is_file($path);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    public static function isLink($path)
    {
        return \is_link($path);
    }

    /**
     * @param string $path
     * @param string $link
     *
     * @return bool
     */
    public static function symlink($path, $link)
    {
        return \symlink($path, $link);
    }

}
