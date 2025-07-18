<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph(5),
            'author' => $this->faker->name,
            'image' => null,
            'views' => $this->faker->numberBetween(0, 100),
            'likes' => $this->faker->numberBetween(0, 50),
        ];
    }
}
