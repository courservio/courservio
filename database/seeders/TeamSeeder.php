<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::create([
            'name' => 'example-team',
            'display_name' => 'Example Team',
            'description' => 'Some description about this team and whats special here...',
        ]);
    }
}
