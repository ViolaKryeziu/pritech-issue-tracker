<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Issue;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $issue = Issue::first();

        Comment::factory()
            ->count(5)
            ->create([
                'issue_id' => $issue->id
            ]);
    }
}
