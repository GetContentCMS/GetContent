<?php

namespace GetContent\CMS\Database\Factories;

use GetContent\CMS\Models\Template;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemplateFactory extends Factory
{
    protected $model = Template::class;

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
