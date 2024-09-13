<?php


use App\Models\IncomeCategory;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\seed;

test('user can delete an income category', function () {
    $user = User::factory()->create();
    $category = IncomeCategory::factory()->create(['user_id' => $user->id]);
    assertDatabaseCount('income_categories', 1);

    $response = actingAs($user)->delete(route('income-categories.destroy',  $category->id));
    $response->assertSessionHasNoErrors();
    $response->assertStatus(302);

    assertDatabaseCount('income_categories', 0);
});

test('user cannot delete a default income category', function () {
    $user = User::factory()->create();
    seed();
    $category = IncomeCategory::query()->first();
    expect($category->user_id)->toBeNull();
    $categoriesCount = IncomeCategory::query()->count();

    $response = actingAs($user)->delete(route('income-categories.destroy', $category->id));
    $response->assertStatus(302);

    expect($categoriesCount === IncomeCategory::query()->count())->toBeTrue();
});
