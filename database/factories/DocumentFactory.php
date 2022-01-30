<?php

namespace GetContent\CMS\Database\Factories;

use GetContent\CMS\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentFactory extends Factory
{
    protected $model = Document::class;

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
