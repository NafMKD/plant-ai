<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // disabling foreign key check for truncating
        // DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();

        User::create([
            'first_name' => 'user',
            'last_name' => 'one',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$tyPIKenH26WPytTmgAHNauXlqzfoWjxRQWzagBQYS4zfMMCUug6ea', // 12345678
        ]);
        // enabling foreign key check after truncating
        // DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
