<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'issue_id' => 1,
            'author_name' => fake()->name(),
            'body' => fake()->sentence(10),
        ];
    }
}
