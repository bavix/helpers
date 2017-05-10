<?php

include_once dirname(__DIR__) . '/vendor/autoload.php';

use Bavix\Helpers\Str;

$text = 'Привет_мир';

$str = Str::translit($text);
var_dump($str);

$str = Str::camelCase($str);
var_dump($str);

$str = Str::camelCase($text, '_', true);
var_dump($str);

$str = Str::snakeCase($str, ' ');
var_dump($str);
