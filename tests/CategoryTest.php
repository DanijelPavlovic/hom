<?php

namespace Tests;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
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
            'api/category',
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


    public function testCategoryCreateNameValidationFails()
    {
        $user = User::factory()->create();

        $testData = [
            "description" => "TEST DESCRIPTION"
        ];

        $response = $this->call(
            'POST',
            'api/category',
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

    public function testUpdateCategorySuccess()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $updatedData = [
            "description" => "Updated Description"
        ];

        $response = $this->call(
            'PUT',
            'api/category/' . $category->id,
            $updatedData,
            [],
            [],
            [
                'HTTP_Authorization' => 'Bearer ' . $user->api_token,
            ]
        );

        $this->actingAs($user);
        $this->assertEquals(200, $response->status());

        $responseData = json_decode($response->getContent())->data;
        $this->assertNotNull(json_decode($response->getContent())->data);
        $this->assertEquals($updatedData['description'], $responseData->category->description);
    }

    public function testDeleteCategory()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->call(
            'DELETE',
            'api/category/' . $category->id,
            [],
            [],
            [],
            [
                'HTTP_Authorization' => 'Bearer ' . $user->api_token,
            ]
        );

        $this->actingAs($user);
        $this->assertEquals(200, $response->status());

        $responseData = json_decode($response->getContent())->data;
        $this->assertEquals('Category deleted', $responseData->message);

        $this->assertTrue(
            !DB::table('categories')
                ->where('id', $category->id)
                ->exists()
        );
    }
}
