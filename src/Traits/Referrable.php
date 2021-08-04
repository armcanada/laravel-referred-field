<?php

namespace Armcanada\LaravelReferredField\Traits;

trait Referrable
{
    public static function findByLabel($label)
    {
        return static::where('label', $label)->first();
    }
}