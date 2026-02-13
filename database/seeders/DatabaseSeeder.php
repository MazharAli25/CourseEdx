<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'super',
            'email' => 'super@gmail.com',
            'role'=> 'super-admin',
            'password'=>Hash::make('111')
        ]);
        User::factory()->create([
            'name' => 'teacher',
            'email' => 'teacher@gmail.com',
            'role'=> 'teacher',
            'password'=>Hash::make('111')
        ]);
        User::factory()->create([
            'name' => 'student',
            'email' => 'student@gmail.com',
            'role'=> 'student',
            'password'=>Hash::make('111')
        ]);
    }
}
