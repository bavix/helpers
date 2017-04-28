<?php

namespace Bavix\Helpers;

class JSON
{

    /**
     * @param string    $value
     * @param int $options
     *
     * @return string
     */
    public static function encode($value, $options = JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK)
    {
        return json_encode($value, $options);
    }

    /**
     * @param string     $json
     * @param bool $assoc
     * @param int  $options
     *
     * @return mixed
     */
    public static function decode($json, $assoc = true, $options = 0)
    {
        return json_decode($json, $assoc, 512, $options);
    }

}
