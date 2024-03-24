<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contact = Contact::first();
        for ($i = 0; $i < 20; $i++) {
            Address::create([
                'street' => 'street' . $i,
                'city' => 'city' . $i,
                'province' => 'province' . $i,
                'country' => 'country' . $i,
                'postal_code' => '123456',
                'contact_id' => $contact->id
            ]);
        }
    }
}
