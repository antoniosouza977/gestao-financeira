<?php

namespace Database\Seeders\modules;

use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!ExpenseCategory::query()->count()) {
            ExpenseCategory::query()->create([
                'name' => 'Alimentação'
            ]);
        }
    }
}
