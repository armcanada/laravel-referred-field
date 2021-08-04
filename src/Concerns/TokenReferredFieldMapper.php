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
            $referredField = ReferredField::findByLabel($token);

            return [
                $token => $referredField
            ];
        });
    }
}