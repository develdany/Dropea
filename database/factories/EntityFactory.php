<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entity>
 */
class EntityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'api' => $this->faker->url,
            'description' => $this->faker->text,
            'link' => $this->faker->url,
            'category_id' => \App\Models\Category::factory(),
        ];
    }
}
