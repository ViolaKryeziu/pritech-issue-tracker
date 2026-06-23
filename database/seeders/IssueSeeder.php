<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Issue;
use App\Models\Project;

class IssueSeeder extends Seeder
{
    public function run(): void
    {
        $project = Project::first();

        if (!$project) {
            $this->command->error('No project found. Run ProjectSeeder first.');
            return;
        }

        Issue::factory()
            ->count(5)
            ->create([
                'project_id' => $project->id
            ]);
    }
}
