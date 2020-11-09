<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create(['id' => 7, 'name' => 'Tyson', 'email' => 'tysonr77@gmail.com', 'password' => Hash::make('oogachuk7&')]);
        $project = $admin->projects()->create(['title' => 'Guitar Lessons', 'description' => 'Learn to play the guitar!']);
        $project->addTask('Find a good teacher');
        $project->addTask('Schedule regular lessons');
        $project->addTask('Buy a capo');

        $admin->projects()->createMany([
            Project::factory()->raw(),
            Project::factory()->raw(),
            Project::factory()->raw(),
            Project::factory()->raw()
        ]);
    }
}
