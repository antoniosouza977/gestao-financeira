<?php

namespace Database\Seeders\modules;

use App\Models\IncomeCategory;
use Illuminate\Database\Seeder;

class IncomeCatergoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        IncomeCategory::query()->updateOrCreate([
            'user_id' => null,
            'name' => 'Salário',
        ]);
    }
}
