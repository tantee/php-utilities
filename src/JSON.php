<?php

namespace TaNteE\PhpUtilities;

class JSON
{
    public static function isJson($string)
    {
        json_decode($string);

        return (json_last_error() == JSON_ERROR_NONE);
    }
}
