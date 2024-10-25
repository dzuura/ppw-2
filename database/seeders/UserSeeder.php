<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Admin User
        DB::table('users')->insert([
            'name' => 'exca',
            'email' => 'exca@gmail.com',
            'password' => Hash::make('admin1234'),
            'level' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed Regular User
        DB::table('users')->insert([
            'name' => 'Ema',
            'email' => 'ema@gmail.com',
            'password' => Hash::make('password123'),
            'level' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed Guest User
        DB::table('users')->insert([
            'name' => 'Loki',
            'email' => 'loki@gmail.com',
            'password' => Hash::make('password123'),
            'level' => 'guest',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
