<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\modules\ExpenseCategoriesSeeder;
use Database\Seeders\modules\IncomeCatergoriesSeeder;
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

        User::query()->updateOrCreate([
            'name'  => 'Test',
            'email' => 'test@example.com'
        ], [
            'name'     => 'Test',
            'email'    => 'test@example.com',
            'password' => Hash::make('Password'),
        ]);

        $this->call([
            IncomeCatergoriesSeeder::class,
            ExpenseCategoriesSeeder::class
        ]);
    }
}
