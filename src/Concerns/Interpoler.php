<?php

namespace Armcanada\LaravelReferredField\Concerns;

use Armcanada\LaravelReferredField\Exceptions\MissingDependencyException;

class Interpoler
{
    private $tokenizer;
    private $mapper;

    public function __construct(Tokenizer $tokenizer = null, TokenReferredFieldMapper $mapper = null)
    {
        $this->tokenizer = $tokenizer ?: new Tokenizer;
        $this->mapper = $mapper ?: new TokenReferredFieldMapper;
    }

    public function interpolate(string $text, array $dependencies = []) : string
    {
        $map = $this->getReferredFieldsFromText($text);
        $replacedMap = $map->mapWithKeys(function($referredField, $token) use($dependencies) {
            if (!isset($dependencies[$referredField?->getOriginal('table')]) && $referredField?->getOriginal('table') !== null) {
                throw new MissingDependencyException($token);
            }
            $key = str_replace(' ', $token, config('laravel-referred-field.interpolation_pattern'));
            return [$key => $referredField?->getReferredValue($dependencies[$referredField?->getOriginal('table') ?? $referredField->handler_dependency_key]) ?? null];
        });
        
        $replacedMap->map(function($newValue, $token) use(&$text) {
            $text = str_replace($token, $newValue, $text);
        });
        return $text;
    }

    public function interpolateUsingDependencies(string $text, array $dependencies = []) : string
    {
        $map = $this->getReferredFieldsFromText($text);
        $replacedMap = $map->mapWithKeys(function($referredField, $token) use($dependencies) {
            if (!isset($dependencies[$referredField?->getOriginal('table')]) && $referredField?->getOriginal('table') !== null) {
                throw new MissingDependencyException($token);
            }
            $key = str_replace(' ', $token, config('laravel-referred-field.interpolation_pattern'));
            if ($referredField?->getOriginal('table') !== null) {
                return [$key => $referredField?->getReferredValue($dependencies[$referredField?->getOriginal('table')]) ?? null];
            } else {
                return [$key => $referredField?->getReferredValue($dependencies)];
            }
        });
        
        $replacedMap->map(function($newValue, $token) use(&$text) {
            $text = str_replace($token, $newValue, $text);
        });
        return $text;
    }

    public function getReferredFieldsFromText($text)
    {
        $tokens = $this->tokenizer->extract($text);
        return $this->mapper->mapTokensToReferredFields($tokens);
    }

}