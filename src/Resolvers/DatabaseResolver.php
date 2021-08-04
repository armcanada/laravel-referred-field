<?php

namespace Armcanada\LaravelReferredField\Resolvers;

use Armcanada\LaravelReferredField\Exceptions\MissingDependencyException;
use Armcanada\LaravelReferredField\Models\ReferredField;
use Illuminate\Support\Facades\DB;

class DatabaseResolver
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
        if(!isset($this->dependencies['id'])) {
            if ($this->referredField->table == null)dd($this);
            throw new MissingDependencyException('id');
        }

        $instance = $this->getTargetedInstance();
        if ($instance) {
            return $instance->{$this->referredField->column};
        }
        return '';
    }

    public function getTargetedInstance()
    {
        return DB::table($this->referredField->table)->select($this->referredField->column)->where('id', $this->dependencies['id'])->first();
    }
}