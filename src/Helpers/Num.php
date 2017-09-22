<?php

namespace Bavix\Helpers;

class Num
{

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
