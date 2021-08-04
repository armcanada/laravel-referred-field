<?php

namespace Armcanada\LaravelReferredField\Models;

use Armcanada\LaravelReferredField\Database\Factories\ReferredFieldFactory;
use Armcanada\LaravelReferredField\Resolvers\DatabaseResolver;
use Armcanada\LaravelReferredField\Resolvers\HandlerResolver;
use Armcanada\LaravelReferredField\Traits\Referrable;
use Illuminate\Database\Eloquent\Model;

class ReferredField extends Model
{
    use Referrable;

    protected $guarded = [];
    protected $table = 'referred_fields';

    protected static function newFactory()
    {
        return ReferredFieldFactory::new();
    }

    public function getReferredValue(array $dependencies) : string
    {
        $resolver = $this->getResolver($dependencies);

        return $resolver->resolve();
    }

    private function getResolver($dependencies)
    {
        if ($this->getOriginal('table') !== null) {
            return new DatabaseResolver($this, $dependencies);
        }
        return new HandlerResolver($this, $dependencies);
    }

}