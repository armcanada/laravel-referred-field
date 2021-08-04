<?php

namespace Armcanada\LaravelReferredField\database\Factories;

use Armcanada\LaravelReferredField\Models\ReferredField;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReferredFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReferredField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           
        ];
    }

    public function testAsTable()
    {
        return $this->state(function(array $attributes) {
            return [
                'label' => 'Nom du client',
                'table' => 'customers',
                'column' => 'name'
            ];
        });
    }
}