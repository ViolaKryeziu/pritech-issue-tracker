<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\User;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $user = User::first() ?? User::factory()->create();

        Project::create([
            'name' => 'Task Management App',
            'description' => 'Main project for issue tracker',
            'start_date' => now(),
            'deadline' => now()->addMonth(),
            'user_id' => $user->id,
        ]);
    }
}
