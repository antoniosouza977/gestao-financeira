<?php

use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

test('deletes an income', function () {
    $user = User::factory()->create();
    $category = IncomeCategory::factory()->create(['user_id' => $user->id]);
    $income = Income::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    expect(Income::query()->count())->toBe(1);

    $this->actingAs($user)
        ->delete(route('incomes.destroy', $income))
        ->assertRedirect(route('incomes.index'));

    expect(Income::query()->count())->toBe(0);
});

test('user cannot delete income from other user', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $category = IncomeCategory::factory()->create(['user_id' => $user1->id]);
    $income = Income::factory()->create([
        'user_id' => $user1->id,
        'category_id' => $category->id,
    ]);

    expect(Income::query()->count())->toBe(1);

    actingAs($user2)
        ->delete(route('incomes.destroy', $income))
        ->assertStatus(403);

    expect(Income::query()->count())->toBe(1);
});


