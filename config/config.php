<?php

/*
 * You can place your custom package configuration in here.
 */
return [
    'interpolation_pattern' => "{{ }}",
    'referred_field_class' => Armcanada\LaravelReferredField\Models\ReferredField::class,
    'connection' => env('DB_CONNECTION', 'mysql'),
];