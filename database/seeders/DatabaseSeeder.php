<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $user = User::query()->updateOrCreate([
            'name'  => 'Test',
            'email' => 'test@example.com'
        ], [
            'name'     => 'Test',
            'email'    => 'test@example.com',
            'password' => Hash::make('Password'),
        ]);

        $incomeCategories = Category::factory(10)->create([
            'user_id' => $user->id,
            'type'    => Category::INCOME
        ]);

        $expenseCategories = Category::factory(10)->create([
            'user_id' => $user->id,
            'type'    => Category::EXPENSE
        ]);

        $categories = $incomeCategories->merge($expenseCategories);

        foreach ($categories as $category) {
            Transaction::factory(5)->create([
                'category_id' => $category->id,
                'user_id'     => $user->id,
                'type'        => $category->type,
            ]);
        }

    }
}
