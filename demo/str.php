<?php

include_once dirname(__DIR__) . '/vendor/autoload.php';

$str = \Bavix\Helpers\Str::translit('Привет мир!');
var_dump($str);
