<?php

namespace Armcanada\LaravelReferredField\Exceptions;

use Exception;

class MissingDependencyException extends Exception
{
    public function __construct($token) {
        $this->message = 'A dependency is missing for token: '.$token;
    }
}