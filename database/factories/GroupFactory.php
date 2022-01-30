<?php

namespace GetContent\CMS\Database\Factories;

use GetContent\CMS\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid,
            'name' => trim($this->faker->sentence(3), '.'),
        ];
    }
}
