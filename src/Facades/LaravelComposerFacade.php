<?php

namespace EmtiazZahid\LaravelComposer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class GitLogFacade
 * @package EmtiazZahid\GitLogLaravel
 */

class LaravelComposerFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'LaravelComposer';
    }
}
