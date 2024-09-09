<?php

namespace Database\Seeders\modules;

use App\Entities\IncomeCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        IncomeCategory::query()->updateOrCreate([
            'user_id' => null,
            'name' => 'Pagamento Avulso',
        ]);
    }
}
