<?php

namespace Tests;

use App\Models\User;
use App\Models\Expense;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    public function testAmountSpent()
    {
        $user = User::factory()->create();

        Expense::factory()->make([
            'user_id' => $user->id,
            'amount' => 30,
            'created_at' => Carbon::now()->subMonth(),
        ]);

        $response = $this->call(
            'GET',
            'api/analytics/amount-spent',
            ['month' => Carbon::now()->month, 'year' => Carbon::now()->year],
            [],
            [],
            [
                'HTTP_Authorization' => 'Bearer ' . $user->api_token,
            ]
        );

        $this->actingAs($user);
        $this->assertEquals(200, $response->status());
        $this->assertNotNull(json_decode($response->getContent())->data);
    }

    public function testRegisterSuccess()
    {
        // Define test data
        $userData = [
            'email' => 'test@example.com',
            'password' => 'test_password',
        ];

        $response = $this->call('POST', 'api/register', $userData);

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

        $response = $this->call('POST', 'api/login', $loginData);

        $this->assertEquals(200, $response->status());
        $this->assertNotNull(json_decode($response->getContent())->data);
    }

    public function testLoginUserNotFound()
    {
        $user = User::factory()->create();

        $loginData = [
            'email' => 'I DO NOT EXIST',
            'password' => '123456',
        ];

        $response = $this->call('POST', 'api/login', $loginData);

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

        $response = $this->call('POST', 'api/login', $loginData);

        $this->assertEquals(401, $response->status());
        $response->assertJson([
            'message' => 'Invalid Credential',
        ]);
    }
}
