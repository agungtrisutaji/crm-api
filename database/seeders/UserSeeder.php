<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'token' => 'test'
        ]);
        User::create([
            'username' => 'admin2',
            'name' => 'Admin2',
            'password' => Hash::make('password2'),
            'token' => 'test2'
        ]);
    }
}
