<?php

namespace Armcanada\LaravelReferredField\Concerns;

use Armcanada\LaravelReferredField\Models\ReferredField;
use ArrayAccess;

/**
 * Maps token to referred field
 */
class TokenReferredFieldMapper
{
    public function mapTokensToReferredFields(array $tokens) : ArrayAccess
    {
        return collect($tokens)->mapWithKeys(function($token) {
            $referredField = config('laravel-referred-field.referred_field_class', Armcanada\LaravelReferredField\Models\ReferredField::class)::findByLabel($token);

            return [
                $token => $referredField
            ];
        });
    }
}