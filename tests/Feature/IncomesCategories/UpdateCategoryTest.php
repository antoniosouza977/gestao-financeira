<?php

use App\Models\IncomeCategory;
use App\Models\User;
use function Pest\Laravel\actingAs;

test('update validation', function () {
    $user = User::factory()->create();
    $category = IncomeCategory::factory()->create(['user_id' => $user->id]);

    $response = actingAs($user)->patch(route('income-categories.update', $category->id), [
        'name' => ''
    ]);

    $response->assertSessionHasErrors('name');
    $response->assertStatus(302);
});

test('cannot update default categories', function () {
    $this->seed();
    $user = User::factory()->create();
    $firstCategory = IncomeCategory::query()->find(1);
    expect($firstCategory->user_id)->toBeNull();

    $response = actingAs($user)->patch(route('income-categories.update', $firstCategory), [
        'name' => 'my category'
    ]);

    $response->assertStatus(403);

    expect(IncomeCategory::query()->find(1)->name !== 'my category')->toBeTrue();
});

test('can update an existing category', function () {
    $user = User::factory()->create();
    $category = IncomeCategory::factory()->create(['name' => 'test', 'user_id' => $user->id]);

    $response = actingAs($user)->patch(route('income-categories.update', $category->id), [
        'name' => 'my category'
    ]);

    $response->assertSessionHasNoErrors();
    $response->assertStatus(302);

    expect(IncomeCategory::query()->find($category->id)->name)->toBe('my category');
});
