<?php

namespace Bavix\Helpers;

class Closure
{

    public static function fromCallable($callable): \Closure
    {
        if (\version_compare(PHP_VERSION, '7.1.0') >= 0)
        {
            return \Closure::fromCallable($callable);
        }

        return function (...$args) use ($callable) {
            return $callable(...$args);
        };
    }

}
