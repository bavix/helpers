<?php

include_once dirname(__DIR__) . '/vendor/autoload.php';

$arr1 = [1];
$arr2 = [2];

var_dump(\Bavix\Helpers\Arr::merge($arr1, $arr2, $arr2));
