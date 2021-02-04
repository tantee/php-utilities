<?php

namespace TaNteE\PhpUtilities;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TaNteE\PhpUtilities\PhpUtilities
 */
class PhpUtilitiesFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'php-utilities';
    }
}
