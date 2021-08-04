<?php

namespace Armcanada\LaravelReferredField\Tests;

use Armcanada\LaravelReferredField\Exceptions\MalformedInterpolationPatternException;
use Armcanada\LaravelReferredField\Concerns\Tokenizer;
use Armcanada\LaravelReferredField\Concerns\TokenReferredFieldMapper;
use Armcanada\LaravelReferredField\Models\ReferredField;
use Illuminate\Support\Facades\Config;

class TokenizerTest extends TestCase
{

    /** @test */
    public function it_extract_tokens_using_pattern_from_config()
    {
        Config::set('laravel-referred-field.interpolation_pattern', '[ ]');
        $stringToInterpolate = 'This should remain {{the}} same!';
        $tokens = (new Tokenizer)->extract($stringToInterpolate);
        $this->assertEmpty($tokens);
       
        Config::set('laravel-referred-field.interpolation_pattern', '{{ }}');
        $tokens = (new Tokenizer)->extract($stringToInterpolate);
        $this->assertEquals($tokens[0], 'the');
    }

    /** @test */
    public function it_throws_when_config_pattern_does_not_contain_a_space()
    {
        $this->expectException(MalformedInterpolationPatternException::class);

        Config::set('laravel-referred-field.interpolation_pattern', '[]');
        $stringToInterpolate = 'This should remain {{the}} same!';
        (new Tokenizer)->extract($stringToInterpolate);
    }

    /** @test */
    public function it_can_extract_tokens_on_multiple_lines_of_text()
    {
        $stringToInterpolate = 'This {{qualifier}} sentence is'.PHP_EOL.'spanning multiple {{another qualifier}} lines!';
        $tokens = (new Tokenizer)->extract($stringToInterpolate);
        $this->assertEquals($tokens[0], 'qualifier');
        $this->assertEquals($tokens[1], 'another qualifier');
    }

    /** @test */
    public function it_maps_a_given_token_to_a_referred_field()
    {
        $rf = ReferredField::newFactory()->testAsTable()->create();

        $stringToInterpolate = 'Bonjour {{Nom du client}}!';
        $tokens = (new Tokenizer)->extract($stringToInterpolate);

        $map = (new TokenReferredFieldMapper)->mapTokensToReferredFields($tokens);

        $this->assertTrue($map->keys()[0] === 'Nom du client');
        $this->assertTrue($map->first()->is($rf));
    }

    /** @test */
    public function it_maps_to_null_when_given_token_has_no_matching_referred_field()
    {
        $rf = ReferredField::newFactory()->testAsTable()->create();

        $stringToInterpolate = '{{color}} is my favorite color.';
        $tokens = (new Tokenizer)->extract($stringToInterpolate);

        $map = (new TokenReferredFieldMapper)->mapTokensToReferredFields($tokens);

        $this->assertTrue($map->keys()[0] === 'color');
        $this->assertTrue($map->first() === null);
    }
    
}