<?php

use Realodix\Utils\Str;

if (! function_exists('Str')) {
    function str($str)
    {
        return new Str($str);
    }
}
