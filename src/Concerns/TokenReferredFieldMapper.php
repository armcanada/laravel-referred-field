<?php

namespace Armcanada\LaravelReferredField\Concerns;

use Armcanada\LaravelReferredField\Models\ReferredField;
use ArrayAccess;
use Illuminate\Database\Eloquent\Collection;

/**
 * Maps token to referred field
 */
class TokenReferredFieldMapper
{
    private Collection $referredFields;

    public function __construct()
    {
        $this->referredFields = (config('laravel-referred-field.referred_field_class', Armcanada\LaravelReferredField\Models\ReferredField::class))::all();    
    }

    public function mapTokensToReferredFields(array $tokens) : ArrayAccess
    {
        return collect($tokens)->mapWithKeys(function($token) {
            $referredField = $this->referredFields->firstWhere('label', $token);

            return [
                $token => $referredField,
            ];
        });
    }
}