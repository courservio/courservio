<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            // deactivated user and team seed. reactive for example use
            // UserSeeder::class,
            // TeamSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
