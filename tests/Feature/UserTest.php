<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testRegisterSuccess()
    {
        $this->post('/api/users', [
            'username' => 'test',
            'password' => 'password',
            'name' => 'test'
        ])->assertStatus(201)
            ->assertJson([
                'data' => [
                    "username" => "test",
                    "name" => "test",
                ]
            ]);
    }

    public function testRegisterFail()
    {
        $this->post('/api/users', [
            'username' => '',
            'password' => '',
            'name' => ''
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    "username" => ['The username field is required.'],
                    "password" => ['The password field is required.'],
                    "name" => ['The name field is required.']
                ]
            ]);
    }

    public function testRegisterUsernameExist()
    {
        $this->testRegisterSuccess();
        $this->post('/api/users', [
            'username' => 'test',
            'password' => 'password',
            'name' => 'test'
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    "username" => ["Username already exists"],

                ]
            ]);
    }
}
