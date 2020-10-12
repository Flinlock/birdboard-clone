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
        User::create(['id' => 7, 'name' => 'Tyson', 'email' => 'tysonr77@gmail.com', 'password' => Hash::make('oogachuk7&')]);
        Project::factory(10)->create();
    }
}
