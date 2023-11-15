<?php

namespace Tests;

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function testRegisterSuccess()
    {
        // Define test data
        $userData = [
            'email' => 'test@example.com',
            'password' => 'test_password',
        ];

        $response = $this->call('POST', 'api/auth/register', $userData);

        $this->assertEquals(200, $response->status());
        $this->assertNotNull(json_decode($response->getContent())->data);
        $this->seeInDatabase('users', [
            'email' => $userData['email'],
        ]);
    }

    public function testLoginSuccess()
    {
        $user = User::factory()->create();

        $loginData = [
            'email' => $user->email,
            'password' => '123456',
        ];

        $response = $this->call('POST', 'api/auth/login', $loginData);

        $this->assertEquals(200, $response->status());
        $this->assertNotNull(json_decode($response->getContent())->data);
    }

    public function testLoginUserNotFound()
    {
        $loginData = [
            'email' => 'I DO NOT EXIST',
            'password' => '123456',
        ];

        $response = $this->call('POST', 'api/auth/login', $loginData);

        $this->assertEquals(404, $response->status());
        $response->assertJson([
            'error' => 'User not found',
        ]);

    }

    public function testLoginPasswordDoesNotMatch()
    {
        $user = User::factory()->create();

        $loginData = [
            'email' => $user->email,
            'password' => 'dont match',
        ];

        $response = $this->call('POST', 'api/auth/login', $loginData);

        $this->assertEquals(401, $response->status());
        $response->assertJson([
            'message' => 'Invalid Credential',
        ]);
    }
}
