<?php

namespace Tests\Feature;

use App\Models\Contact;
use Database\Seeders\ContactSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressTest extends TestCase
{
    public function testCreateSuccess()
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);
        $contact = Contact::first();
        $this->post('/api/contacts/' . $contact->id . '/addresses', [
            'street' => 'street',
            'city' => 'city',
            'province' => 'province',
            'country' => 'country',
            'postal_code' => 'postal_code'
        ], [
            'Authorization' => 'test'
        ])->assertStatus(201)
            ->assertJson([
                'data' => [
                    'street' => 'street',
                    'city' => 'city',
                    'province' => 'province',
                    'country' => 'country',
                    'postal_code' => 'postal_code'
                ]
            ]);
    }

    public function testCreateFail()
    {
    }

    public function testCreateNotFound()
    {
    }
}
