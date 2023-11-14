<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;
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
                'description' => 'weekly food shoopping',
                'amount' => 10,
                'category_id' => 1,
                'user_id' => $user->id,
            ],
            [
                'description' => 'Takeout',
                'amount' => 5,
                'category_id' => 1,
                'user_id' => $user->id,
            ],
            [
                'description' => 'Gym membership',
                'amount' => 10,
                'category_id' => 2,
                'user_id' => $user->id,
            ],
            [
                'description' => 'bought headphones',
                'amount' => 50,
                'category_id' => 4,
                'user_id' => $user->id,
            ],
        ]);

        $expenses->each(function ($expense) {
            Expense::create($expense);
        });
    }
}
