<?php

namespace Database\Factories;

use App\Models\Nava;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nava>
 */
class NavaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->sentence(2),
            "type" => $this->faker->randomElements(Nava::ARRAY_CONTENT_TYPE),
            "file_urls" => ['https://www.w3schools.com/html/mov_bbb.mp4']
        ];
    }
}
