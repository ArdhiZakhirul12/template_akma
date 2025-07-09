<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Reihan Wudd Hibatullah',
            'email' => 'tes@gmail.com',
            'password' => bcrypt('password'),
        ]);
    }
}
