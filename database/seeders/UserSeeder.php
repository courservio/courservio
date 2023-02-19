<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@example.fail',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'active' => 1,
        ]);

        $user->attachRole('admin');
    }
}
