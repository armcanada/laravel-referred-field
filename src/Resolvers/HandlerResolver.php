<?php

namespace Armcanada\LaravelReferredField\Resolvers;

use Armcanada\LaravelReferredField\Exceptions\MissingDependencyException;
use Armcanada\LaravelReferredField\Models\ReferredField;
use Illuminate\Support\Facades\DB;

class HandlerResolver
{
    private $referredField;
    private $dependencies;

    public function __construct(ReferredField $referredField, array $dependencies)
    {
        $this->referredField = $referredField;
        $this->dependencies = $dependencies;
    }

    public function resolve() : string
    {
        $handlerClass = $this->referredField->handler;
        $handler = new $handlerClass($this->dependencies);
        
        return $handler->execute();
    }
}