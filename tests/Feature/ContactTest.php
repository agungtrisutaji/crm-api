<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    public function testCreateSuccess()
    {
        $this->seed([UserSeeder::class]);

        $this->post('/api/contacts', [
            'first_name' => 'Agung',
            'last_name' => 'Trisutaji',
            'email' => 'agung@example.com',
            'phone' => '03242343243'
        ], [
            'Authorization' => 'test'
        ])->assertStatus(201)
            ->assertJson([
                'data' => [
                    'first_name' => 'Agung',
                    'last_name' => 'Trisutaji',
                    'email' => 'agung@example.com',
                    'phone' => '03242343243'
                ]
            ]);
    }

    public function testCreateFailed()
    {
        $this->seed([UserSeeder::class]);

        $this->post('/api/contacts', [
            'first_name' => '',
            'last_name' => 'Trisutaji',
            'email' => 'agung',
            'phone' => '03242343243'
        ], [
            'Authorization' => 'test'
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'first_name' => [
                        'The first name field is required.'
                    ],
                    'email' => [
                        'The email field must be a valid email address.'
                    ]
                ]
            ]);
    }

    public function testCreateUnauthorized()
    {
        $this->seed([UserSeeder::class]);

        $this->post('/api/contacts', [
            'first_name' => 'Agung',
            'last_name' => 'Trisutaji',
            'email' => 'agung@example.com',
            'phone' => '03242343243'
        ], [
            'Authorization' => 'salah'
        ])->assertStatus(401)
            ->assertJson([
                'message' => [
                    'Unauthorized'
                ]
            ]);
    }
}
