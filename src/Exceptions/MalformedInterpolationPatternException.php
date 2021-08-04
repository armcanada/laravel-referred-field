<?php

namespace Armcanada\LaravelReferredField\Exceptions;

use Exception;

class MalformedInterpolationPatternException extends Exception
{
    protected $message = 'Malformed interpolation pattern, ensure you have an opening and closing character separated by a space.';
}