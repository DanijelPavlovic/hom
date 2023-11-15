<?php

namespace Tests;

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;
use Carbon\Carbon;
use App\Models\Expense;

class AnalyticsTest extends TestCase
{
    use DatabaseTransactions;

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
}
