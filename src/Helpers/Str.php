<?php

namespace Bavix\Helpers;

use Bavix\Exceptions;
use function Bavix\tables\trans;

class Str
{

    const DIGITS        = '0123456789';
    const ALPHABET_LOW  = 'abcdefghijklmnopqrstuvwxyz';
    const ALPHABET_HIGH = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const ALPHABET      = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    const RAND_ALPHA_LOW  = 1;
    const RAND_ALPHA_HIGH = 2;
    const RAND_ALPHA      = 4;
    const RAND_DIGITS     = 8;
    const RAND_ALL        = 16;

    /**
     * @var array
     */
    protected static $dictionary = [
        4 => self::ALPHABET . self::DIGITS,
        3 => self::DIGITS,
        2 => self::ALPHABET,
        1 => self::ALPHABET_HIGH,
        0 => self::ALPHABET_LOW,
    ];

    /**
     * @return array
     */
    protected static function table()
    {
        $file = \dirname(__DIR__, 2) . '/data/trans.php';

        if (!\opcache_is_script_cached($file))
        {
            \opcache_compile_file($file);
        }

        return trans();
    }

    /**
     * @param string $str
     * @param int    $length
     *
     * @return array
     */
    public static function split($str, $length = 1)
    {
        return \str_split($str, $length);
    }

    /**
     * Shortens text to length and keeps integrity of words
     *
     * @param  string  $str
     * @param  integer $length
     * @param  string  $end
     *
     * @return string
     */
    public static function shorten($str, $length = 100, $end = '&#8230;')
    {
        if (strlen($str) > $length)
        {
            $str = \substr(trim($str), 0, $length);
            $str = \substr($str, 0, -\strpos(\strrev($str), ' '));
            $str = \trim($str . $end);
        }

        return $str;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function ucFirst($string)
    {
        $first = static::sub($string, 0, 1);
        $first = static::upp($first);

        return $first . static::sub($string, 1);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function lcFirst($string)
    {
        $first = static::sub($string, 0, 1);
        $first = static::low($first);

        return $first . static::sub($string, 1);
    }

    /**
     * Return random string
     *
     * @param  int $length
     * @param  int $type
     *
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    public static function random($length = 32, $type = self::RAND_ALL)
    {
        $string = '';
        // todo: make to halper?
        foreach (static::$dictionary as $pos => $item)
        {
            $key = (1 << $pos);
            if ($type >= $key)
            {
                $string .= $item;
                $type   -= $key;
            }
        }

        if (empty($string))
        {
            throw new Exceptions\Blank("Invalid random string type [{$type}].");
        }

        return static::rand($string, $length);
    }

    /**
     * @param string $chars
     * @param int    $length
     *
     * @return string
     */
    protected static function rand($chars, $length)
    {
        $string = '';
        $max    = static::len($chars) - 1;
        $i      = 0;

        while ($i < $length)
        {
            $string .= $chars[\random_int(0, $max)];
            $i++;
        }

        return $string;
    }

    /**
     * @return string
     */
    public static function uniqid()
    {
        return \uniqid(\random_int(\PHP_INT_MIN, \PHP_INT_MAX), true);
    }

    /**
     * @param int $size
     * @param int $decimals
     *
     * @return string
     */
    public static function fileSize($size, $decimals = 2)
    {
        switch (true)
        {
            case $size >= ((1 << 50) * 10):
                $postfix = 'PB';
                $size    /= (1 << 50);
                break;
            case $size >= ((1 << 40) * 10):
                $postfix = 'TB';
                $size    /= (1 << 40);
                break;
            case $size >= ((1 << 30) * 10):
                $postfix = 'GB';
                $size    /= (1 << 30);
                break;
            case $size >= ((1 << 20) * 10):
                $postfix = 'MB';
                $size    /= (1 << 20);
                break;
            case $size >= ((1 << 10) * 10):
                $postfix = 'KB';
                $size    /= (1 << 10);
                break;
            default:
                $postfix = 'B';
        }

        return \round($size, $decimals) . ' ' . $postfix;
    }

    /**
     * transliteration cyr->lat
     *
     * @param $string
     *
     * @return string
     */
    public static function translit($string)
    {
        $string = \strtr($string, static::table());

        return \iconv(\mb_internal_encoding(), 'ASCII//TRANSLIT', $string);
    }

    /**
     * @param string $string
     * @param int    $start
     * @param int    $length
     *
     * @return string
     */
    public static function sub($string, $start, $length = null)
    {
        return \mb_substr($string, $start, $length);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function upp($string)
    {
        return \mb_convert_case($string, MB_CASE_UPPER);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function low($string)
    {
        return \mb_convert_case($string, MB_CASE_LOWER);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function capitalize($string)
    {
        return \mb_convert_case($string, MB_CASE_TITLE);
    }

    /**
     * @param string $string
     *
     * @return string mixed
     */
    public static function toNumber($string)
    {
        return \preg_replace('/\D/', '', $string);
    }

    /**
     * @param string $string
     * @param string $needle
     * @param int    $offset
     *
     * @return int
     */
    public static function pos($string, $needle, $offset = null)
    {
        return \mb_strpos($string, $needle, $offset);
    }

    /**
     * @param string $string
     * @param int    $multiplier
     *
     * @return string
     */
    public static function repeat($string, $multiplier)
    {
        return \str_repeat($string, $multiplier);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function shuffle($string)
    {
        return static::rand($string, static::len($string));
    }

    /**
     * @param string $string
     *
     * @return int
     */
    public static function len($string)
    {
        return \mb_strlen($string);
    }

}
