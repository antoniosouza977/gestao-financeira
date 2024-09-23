<?php

namespace Database\Seeders\modules;

use App\Models\Category;
use Illuminate\Database\Seeder;

class IncomeCatergoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Category::query()->count()) {
            Category::query()->updateOrCreate([
                'user_id' => null,
                'name'    => 'Salário',
            ]);
        }
    }
}
