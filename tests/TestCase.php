<?php

namespace Armcanada\LaravelReferredField\Tests;

use Armcanada\LaravelReferredField\LaravelReferredFieldServiceProvider;
use Orchestra\Testbench\TestCase as OchestraTestCase;

abstract class TestCase extends OchestraTestCase
{
    protected function getPackageProviders($app)
    {
       return [
           LaravelReferredFieldServiceProvider::class
       ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'LaravelReferredField' => 'Armcanada\LaravelReferredField'
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        include_once __DIR__.'/../database/migrations/create_referred_fields_table.php.stub';
        (new \CreateReferredFieldsTable)->up();
    }

}