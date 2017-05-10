<?php

include_once dirname(__DIR__) . '/vendor/autoload.php';

// заголовок
$str = 'В Москве возобновили  一   一  一 отопление жилых домов и 一 соцобъектов';

var_dump(\Bavix\Helpers\Str::friendlyUrl($str));

var_dump(\Bavix\Helpers\Str::friendlyUrl($str, false));

var_dump(\Bavix\Helpers\Str::friendlyUrl($str, true, \Bavix\Helpers\Str::CAMEL_CASE));

var_dump(\Bavix\Helpers\Str::friendlyUrl($str, false, \Bavix\Helpers\Str::CAMEL_CASE));
