<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
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

    public function testLoginSuccess()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/users/login', [
            'username' => 'admin',
            'password' => 'password',
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    "username" => "admin",
                    "name" => "Admin",
                ]
            ]);

        $user = User::where('username', 'admin')->first();
        self::assertNotNull($user->token);
    }

    public function testLoginFail()
    {
        $this->post('/api/users/login', [
            'username' => 'admin',
            'password' => 'password',
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    "message" => ["Username or Password wrong"],
                ]
            ]);
    }

    public function testLoginPasswordFail()
    {
        $this->seed([UserSeeder::class]);
        $this->post('/api/users/login', [
            'username' => 'admin',
            'password' => 'salah',
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    "message" => ["Username or Password wrong"],
                ]
            ]);
    }

    public function testGetSuccess()
    {
        $this->seed([UserSeeder::class]);

        $this->get('/api/users/current', [
            'Authorization' => 'test',
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    "username" => "admin",
                    "name" => "Admin",
                ]
            ]);
    }
    public function testGetUnauthorized()
    {
        $this->seed([UserSeeder::class]);

        $this->get('/api/users/current', [])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    "message" => ["Unauthorized"]
                ]
            ]);
    }
    public function testGetInvalidToken()
    {
        $this->seed([UserSeeder::class]);

        $this->get('/api/users/current', [
            'Authorization' => 'salah',
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    "message" => ["Unauthorized"]
                ]
            ]);
    }

    public function testUpdateNameSuccess()
    {
        $this->seed([UserSeeder::class]);
        $oldUser = User::where('username', 'admin')->first();

        $this->patch(
            '/api/users/current',
            [
                'name' => 'Nama Baru',
            ],
            [
                'Authorization' => 'test'
            ]
        )->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => 'admin',
                    'name' => 'Nama Baru',
                ]
            ]);

        $newUser = User::where('username', 'admin')->first();
        self::assertNotEquals($oldUser->name, $newUser->name);
    }

    public function testUpdatePasswordSuccess()
    {
        $this->seed([UserSeeder::class]);
        $oldUser = User::where('username', 'admin')->first();

        $this->patch(
            '/api/users/current',
            [
                'password' => 'baru'
            ],
            [
                'Authorization' => 'test'
            ]
        )->assertStatus(200)
            ->assertJson([
                'data' => [
                    'username' => 'admin',
                    'name' => 'Admin'
                ]
            ]);

        $newUser = User::where('username', 'admin')->first();
        self::assertNotEquals($oldUser->password, $newUser->password);
    }

    public function testUpdateFail()
    {
        $this->seed([UserSeeder::class]);

        $this->patch(
            '/api/users/current',
            [
                'name' => 'AgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgungAgung'
            ],
            [
                'Authorization' => 'test'
            ]
        )->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'name' => [
                        "The name field must not be greater than 100 characters."
                    ]
                ]
            ]);
    }
}
