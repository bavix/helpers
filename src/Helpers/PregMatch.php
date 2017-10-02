<?php

namespace Bavix\Helpers;

class PregMatch
{

    /**
     * @param Results\PregObject|null $object
     *
     * @return Results\PregObject
     */
    protected static function pregObject(Results\PregObject $object = null): Results\PregObject
    {
        if (!$object)
        {
            return new Results\PregObject();
        }

        return $object;
    }

    /**
     * @param string                  $pattern
     * @param string                  $subject
     * @param Results\PregObject|null $object
     *
     * @return Results\PregObject
     */
    public static function first($pattern, $subject, Results\PregObject $object = null): Results\PregObject
    {
        $object = static::pregObject($object);

        $object->result = \preg_match(
            $pattern,
            $subject,
            $object->matches,
            $object->flags,
            $object->offset
        );

        return $object;
    }

    /**
     * @param string                  $pattern
     * @param string                  $subject
     * @param Results\PregObject|null $object
     *
     * @return Results\PregObject
     */
    public static function all($pattern, $subject, Results\PregObject $object = null): Results\PregObject
    {
        $object = static::pregObject($object);

        $object->flags  = null === $object->flags ? $object->flags : PREG_PATTERN_ORDER;
        $object->result = \preg_match_all(
            $pattern,
            $subject,
            $object->matches,
            $object->flags,
            $object->offset
        );

        return $object;
    }

}
