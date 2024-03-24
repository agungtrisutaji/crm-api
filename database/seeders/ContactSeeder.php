<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('username', 'agung')->first();
        Contact::create([
            'first_name' => 'Agung',
            'last_name' => 'Trisutaji',
            'email' => 'agung@example.com',
            'phone' => '03242343243',
            'user_id' => $user->id
        ]);
    }
}
