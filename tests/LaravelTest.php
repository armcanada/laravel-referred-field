<?php

namespace Armcanada\LaravelReferredField\Tests;

use Armcanada\LaravelReferredField\Models\ReferredField;
use Armcanada\LaravelReferredField\Traits\Referrable;

class LaravelTest extends TestCase
{

    /** @test */
    public function it_can_access_the_database()
    {
        $rf = new ReferredField();
        $rf->label = 'test';
        $rf->save();

        return $this->assertSame($rf->label, 'test');
    }

    /** @test */
    public function it_ensure_trait_can_be_used_by_a_class()
    {
        $object = new class { use Referrable; };

        $objectUsesTrait = in_array(
            Referrable::class,
            array_keys((new \ReflectionClass($object))->getTraits())
        );
        
        $this->assertTrue($objectUsesTrait);
    }

}