<?php

include_once dirname(__DIR__) . '/vendor/autoload.php';

var_dump(\Bavix\Helpers\Closure::fromCallable('mb_strlen')('hello'));
