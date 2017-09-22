<?php

namespace Bavix\Helpers;

class Num
{

    /**
     * @param int $min
     * @param int $max
     *
     * @return int
     * @throws \Exception
     */
    public static function randomInt($min = PHP_INT_MIN, $max = PHP_INT_MAX)
    {
        return \random_int($min, $max);
    }

    /**
     * @param int|float|double $number
     * @param int              $decimals
     * @param string           $decPoint
     * @param string           $thousandsSep
     *
     * @return string
     */
    public static function format($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        return \number_format($number, $decimals, $decPoint, $thousandsSep);
    }

}
