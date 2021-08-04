<?php

namespace Armcanada\LaravelReferredField\Tests;

use Armcanada\LaravelReferredField\Exceptions\MissingDependencyException;
use Armcanada\LaravelReferredField\Models\ReferredField;
use Armcanada\LaravelReferredField\Resolvers\HandlerResolver;

class ReferredFieldTest extends TestCase
{

    /** @test */
    public function it_will_throw_if_no_id_is_present_in_dependency()
    {
        $this->expectException(MissingDependencyException::class);

        $rf = ReferredField::newFactory()->testAsTable()->create();
        $rf->getReferredValue([]);
    }

    /** @test */
    public function it_will_use_a_handler_resolver_and_return_the_value()
    {
        $rf = ReferredField::create(['label' => 'Montant en souffrance', 'handler' => 'Armcanada\LaravelReferredField\Tests\TestClasses\OutstandingAmountHandler', 'table' => null ]);

        $value = $rf->getReferredValue(['Montant en souffrance']);

        $this->assertEquals('100', $value);
    }

   

}