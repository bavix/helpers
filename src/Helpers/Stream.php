<?php

namespace Bavix\Helpers;

use Bavix\Exceptions;
use Bavix\Exceptions\NotFound;

class Stream
{

    /**
     * @param string $from
     * @param string $to
     *
     * @return boolean
     *
     * @throws Exceptions\PermissionDenied
     * @throws NotFound\Path
     */
    public static function download($from, $to)
    {
        $fromStream = File::open($from);

        if (!$fromStream)
        {
            throw new NotFound\Path('Stream `' . $from . '` not found');
        }

        if (!File::real($to) && !File::touch($to))
        {
            throw new Exceptions\PermissionDenied('File `' . $to . '`');
        }

        File::put($to, $fromStream);

        return File::close($fromStream);
    }

}
