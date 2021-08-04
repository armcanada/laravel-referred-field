<?php

namespace Armcanada\LaravelReferredField\Concerns;

use Armcanada\LaravelReferredField\Exceptions\MalformedInterpolationPatternException;
use Illuminate\Support\Arr;

class Tokenizer
{
    private $pattern;
    private $enclosureStartCharacters;
    private $enclosureEndCharacters;

    public function __construct()
    {
        if (!str_contains(config('laravel-referred-field.interpolation_pattern'), ' ')) {
            throw new MalformedInterpolationPatternException();
        }
        [$this->enclosureStartCharacters, $this->enclosureEndCharacters] = explode(' ', config('laravel-referred-field.interpolation_pattern'));
        $this->pattern = $this->generateRegexPattern();

    }

    /**
     * Generate a regex pattern based on config key interpolation_pattern
     */
    private function generateRegexPattern() : string
    {
        if (!str_contains(config('laravel-referred-field.interpolation_pattern'), ' ')) {
            throw new MalformedInterpolationPatternException();
        }
    
        $pattern = '/(';
        foreach(Arr::wrap($this->enclosureStartCharacters) as $character) {
            $pattern .= '\\'.$character;
        }

        $pattern .= '(\w+ {0,1}\w+)+';

        foreach(Arr::wrap($this->enclosureEndCharacters) as $character) {
            $pattern .= '\\'.$character;
        }

        $pattern .= ')/miu';
        
        return $pattern;
    }

    /**
     * Returns an array of all of the matched tokens
     */
    public function extract(string $text) : array
    {
        $matches = [];
        preg_match_all($this->pattern, $text, $matches, PREG_SET_ORDER);

        return array_map(function($matchGroups) {
            $withoutStartingEnclosure = str_replace($this->enclosureStartCharacters, '', $matchGroups[0]);
            return str_replace($this->enclosureEndCharacters, '', $withoutStartingEnclosure);
        }, $matches);
    }

    public function getRegexPattern()
    {
        return $this->pattern;
    }
}