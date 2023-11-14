<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = collect([
            ["name" => "FOOD", "description" => "Food budget"],
            ["name" => "FITNESS", "description" => "Fitness budget"],
            ["name" => "WORK", "description" => "Work budget"],
            ["name" => "TECH", "description" => "Tech budget"],
        ]);

        $categories->each(function ($category) {
            Category::create($category);
        });

        $user = User::create([
            'email' => 'testUser@local.tbd',
            'password' => Hash::make('123456'),
            'api_token' => hash('sha256', Str::random(60)),
        ]);

        $expenses = collect([
            [
                'description' => 'Weekly food shoopping',
                'amount' => 50,
                'category_id' => 1,
                'user_id' => $user->id,
            ],
            [
                'description' => 'Takeout McDonalds',
                'amount' => 10,
                'category_id' => 1,
                'user_id' => $user->id,
            ],
            [
                'description' => 'Takeout Pancakes',
                'amount' => 20,
                'category_id' => 1,
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subMonth()->format('Y-m-d H:i:s'),
            ],
            [
                'description' => 'Takeout Pizza',
                'amount' => 15,
                'category_id' => 1,
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subDays(35)->format('Y-m-d H:i:s'),
            ],
            [
                'description' => 'Gym membership',
                'amount' => 20,
                'category_id' => 2,
                'user_id' => $user->id,
            ],
            [
                'description' => 'Gym membership',
                'amount' => 20,
                'category_id' => 2,
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subMonth()->format('Y-m-d H:i:s'),
            ],
            [
                'description' => 'Gym membership',
                'amount' => 20,
                'category_id' => 2,
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subMonths(3)->format('Y-m-d H:i:s'),
            ],
            [
                'description' => 'Gym membership',
                'amount' => 20,
                'category_id' => 2,
                'user_id' => $user->id,
                'created_at' => Carbon::now()->subMonths(5)->format('Y-m-d H:i:s'),
            ],
            [
                'description' => 'Supplements',
                'amount' => 20,
                'category_id' => 2,
                'user_id' => $user->id,
            ],
            [
                'description' => 'Headphones',
                'amount' => 100,
                'category_id' => 4,
                'user_id' => $user->id,
            ],
            [
                'description' => 'Monitor',
                'amount' => 300,
                'category_id' => 4,
                'user_id' => $user->id,
            ],
        ]);

        $expenses->each(function ($expense) {
            Expense::create($expense);
        });
    }
}
