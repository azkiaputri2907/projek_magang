<?php

namespace Database\Seeders;

// database/seeders/AdminUserSeeder.php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Administrator',
            'email' => 'azkia@admin.com',
            'password' => Hash::make('kiakia1'), // Ganti 'password' dengan password kuat
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
