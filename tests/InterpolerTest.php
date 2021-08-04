<?php

namespace Armcanada\LaravelReferredField\Tests;

use Armcanada\LaravelReferredField\Concerns\Interpoler;
use Armcanada\LaravelReferredField\Concerns\Tokenizer;
use Armcanada\LaravelReferredField\Concerns\TokenReferredFieldMapper;
use Armcanada\LaravelReferredField\Models\ReferredField;
use Illuminate\Support\Facades\Config;

class InterpolerTest extends TestCase
{
    private $interpoler;

    public function setUp() : void
    {
        parent::setup();

        Config::set('interpolation_pattern', '{{ }}');
        $this->interpoler = new Interpoler(new Tokenizer, new TokenReferredFieldMapper);
    }

    /** @test */
    public function it_returns_blanked_tokens_when_referred_field_is_not_found()
    {
        $rf = ReferredField::create(['label' => 'adj', 'table' => 'referred_fields', 'column' => 'id']);

        $this->partialMock(DatabaseResolver::class)
            ->shouldReceive('getTargetedInstance')
            ->andReturn($rf);
            $stringToInterpolate = 'This is a {{adj}} day!';
            $interpolatedString = $this->interpoler->interpolate($stringToInterpolate, ['referred_fields' => ['id' => -1]]);


        $this->assertEquals('This is a  day!', $interpolatedString);
    }

    /** @test */
    public function it_returns_the_interpolated_string_from_db_value()
{
    $rf = ReferredField::create(['label' => 'adj', 'table' => 'referred_fields', 'column' => 'id']);

    $this->partialMock(DatabaseResolver::class)
         ->shouldReceive('getTargetedInstance')
         ->andReturn($rf);
         $stringToInterpolate = 'This is a {{adj}} day!';
         $interpolatedString = $this->interpoler->interpolate($stringToInterpolate, ['referred_fields' => ['id' => 1]]);


    $this->assertEquals('This is a 1 day!', $interpolatedString);
}

}