<?php

namespace Bavix\Helpers\Results;

use Bavix\Helpers\Arr;

/**
 * Class PregObject
 *
 * @package Bavix\Helpers\Results
 *
 * @property array $matches
 * @property int   $flags
 * @property int   $offset
 * @property int   $result
 */
class PregObject
{

    /**
     * @var array
     */
    protected $data = [];

    /**
     * PregObject constructor.
     *
     * @param int $flags
     * @param int $offset
     */
    public function __construct($flags = 0, $offset = 0)
    {
        $this->flags  = $flags;
        $this->offset = $offset;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function &__get($name)
    {
        if (!Arr::keyExists($this->data, $name))
        {
            $this->data[$name] = null;
        }

        return $this->data[$name];
    }

    /**
     * @param string $name
     * @param mixed  $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

}
