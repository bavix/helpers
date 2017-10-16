<?php

namespace Bavix\Helpers;

use Bavix\Exceptions;
use Bavix\Exceptions\NotFound;

class Arr
{

    /**
     * @param array    $storage
     * @param callable $callback
     *
     * @return bool
     */
    public static function walkRecursive(array &$storage, callable $callback)
    {
        return \array_walk_recursive($storage, $callback);
    }

    /**
     * @param array    $storage
     * @param callable $callback
     *
     * @return array
     */
    public static function map(array $storage, $callback)
    {
        return \array_map($callback, $storage);
    }

    /**
     * @param array $storage
     * @param int   $offset
     * @param int   $length
     *
     * @return array
     */
    public static function slice(array $storage, $offset, $length = null)
    {
        return \array_slice($storage, $offset, $length);
    }

    /**
     * @param array   $first
     * @param array[] ...$second
     *
     * @return array
     */
    public static function merge(array $first, array ...$second)
    {
        return \array_merge($first, ...$second);
    }

    /**
     * @param array    $storage
     * @param callable $callback
     *
     * @return array
     */
    public static function filter(array $storage, $callback)
    {
        return \array_filter($storage, $callback, ARRAY_FILTER_USE_BOTH);
    }

    /**
     * @param     $string
     * @param     $length
     * @param int $start
     *
     * @return array
     */
    public static function fill($string, $length, $start = 0)
    {
        return \array_fill($start, $length, $string);
    }

    /**
     * @param mixed $begin
     * @param mixed $end
     * @param int   $step
     *
     * @return array
     */
    public static function range($begin, $end, $step = 1)
    {
        return \range($begin, $end, $step);
    }

    /**
     * @param array $storage
     * @param mixed $needle
     * @param bool  $strict
     *
     * @return bool
     */
    public static function in(array $storage, $needle, $strict = true)
    {
        return \in_array($needle, $storage, $strict);
    }

    /**
     * @param array $storage
     *
     * @return bool
     */
    public static function shuffle(array &$storage)
    {
        return \shuffle($storage);
    }

    /**
     * @param array  $storage
     * @param string $path
     * @param mixed  $value
     */
    public static function set(array &$storage, $path, $value)
    {
        $rows           = &static::link($storage, $path, $lastKey);
        $rows[$lastKey] = $value;
    }

    /**
     * @param array  $storage
     * @param string $path
     */
    public static function remove(array &$storage, $path)
    {
        $rows = &static::link($storage, $path, $lastKey);
        unset($rows[$lastKey]);
    }

    /**
     * @param array $storage
     * @param string $key
     *
     * @return array|mixed
     *
     * @throws NotFound\Path
     * @throws Exceptions\Blank
     */
    public static function getRequired(array $storage, $key)
    {
        return static::findPath($storage, static::keys($key));
    }

    /**
     * @param array $storage
     * @param array $keys
     *
     * @return array|mixed
     *
     * @throws NotFound\Path
     * @throws Exceptions\Blank
     */
    protected static function findPath(array $storage, array $keys)
    {
        if (!count($keys) || $keys[0] === '')
        {
            throw new Exceptions\Blank('Not found keys');
        }

        $rows = &$storage;

        foreach ($keys as $key)
        {
            if (!static::keyExists($rows, $key))
            {
                throw new NotFound\Path('Path `' . implode('.', $keys) . '` not found');
            }

            $rows = &$rows[$key];
        }

        return $rows;
    }

    /**
     * @param array $storage
     * @param       $mixed
     *
     * @return int
     */
    public static function push(array &$storage, $mixed)
    {
        return \array_push($storage, $mixed);
    }

    /**
     * @param array $storage
     *
     * @return mixed
     */
    public static function pop(array &$storage)
    {
        return \array_pop($storage);
    }

    /**
     * @param array $storage
     *
     * @return mixed
     */
    public static function shift(array &$storage)
    {
        return \array_shift($storage);
    }

    /**
     * @param array $storage
     * @param       $mixed
     *
     * @return int
     */
    public static function unShift(array &$storage, $mixed)
    {
        return \array_unshift($storage, $mixed);
    }

    /**
     * @param array  $storage
     * @param string $key
     * @param mixed  $default
     *
     * @return mixed
     */
    public static function get(array $storage, $key, $default = null)
    {
        try
        {
            return static::findPath($storage, static::keys($key));
        }
        catch (\InvalidArgumentException $argumentException)
        {
            return $default;
        }
    }

    /**
     * @param array|\Traversable $iterator
     *
     * @return array
     */
    public static function iterator($iterator)
    {
        if (\is_array($iterator))
        {
            return $iterator;
        }
        
        return \iterator_to_array($iterator);
    }
    
    /**
     * @param array $storage
     *
     * @return array
     */
    public static function getValues(array $storage)
    {
        return \array_values($storage);
    }

    /**
     * @param array $storage
     *
     * @return array
     */
    public static function getKeys(array $storage)
    {
        return \array_keys($storage);
    }

    /**
     * @param string $offset
     *
     * @return array
     */
    public static function keys($offset)
    {
        $offset = \trim($offset);
        $offset = \preg_replace('~\[(?<s>[\'"]?)(.*?)(\k<s>)\]~u', '.$2', $offset);

        return \explode('.', $offset);
    }

    /**
     * @param array  $storage
     * @param string $key
     *
     * @return bool
     */
    public static function keyExists(array $storage, $key)
    {
        return isset($storage[$key]) || \array_key_exists($key, $storage);
    }

    /**
     * @param array  $storage
     * @param string $key
     *
     * @return mixed
     */
    public static function at(array $storage, $key)
    {
        return $storage[$key];
    }

    /**
     * @param array  $storage
     * @param string $key
     * @param mixed  $value
     */
    public static function initOrPush(array &$storage, $key, $value)
    {
        if (empty($storage[$key]))
        {
            $storage[$key] = [];
        }

        $storage[$key][] = $value;
    }

    /**
     * @param array  $storage
     * @param string $path
     * @param string $lastKey
     *
     * @return array
     */
    protected static function &link(array &$storage, $path, &$lastKey)
    {
        $keys    = static::keys($path);
        $lastKey = \array_pop($keys);
        $rows    = &$storage;

        foreach ($keys as $key)
        {
            if (!static::keyExists($rows, $key))
            {
                $rows[$key] = [];
            }
            $rows = &$rows[$key];
        }

        return $rows;
    }

}
