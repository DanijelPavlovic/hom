<?php

namespace Tests;

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use DatabaseTransactions;


    public function testCategoryCreateSuccess()
    {
        $user = User::factory()->create();

        $testData = [
            "name" => "TEST",
            "description" => "TEST DESCRIPTION"
        ];

        $response = $this->call(
            'POST',
            'api/category/store',
            $testData,
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


    public function testCategoryCreateNameValidation()
    {
        $user = User::factory()->create();

        $testData = [
            "description" => "TEST DESCRIPTION"
        ];

        $response = $this->call(
            'POST',
            'api/category/store',
            $testData,
            [],
            [],
            [
                'HTTP_Authorization' => 'Bearer ' . $user->api_token,
            ]
        );

        $this->actingAs($user);
        $this->assertEquals(422, $response->status());
        $response->assertJson([
            "name" => [
                "The name field is required."
            ]
        ]);
    }
}
