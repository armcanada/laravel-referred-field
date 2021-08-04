<?php

namespace Armcanada\LaravelReferredField;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Armcanada\LaravelReferredField\Skeleton\SkeletonClass
 */
class LaravelReferredFieldFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-referred-field';
    }
}
