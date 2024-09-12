<?php

use App\Models\IncomeCategory;
use App\Models\User;

test('validation test', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)
        ->post(route('income-categories.store'), ['name' => '',]);

    $response->assertSessionHasErrors(['name']);
    $response->assertStatus(302);
});

test('creation of category test', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post(route('income-categories.store'), ['name' => 'teste',]);

    $response->assertSessionHasNoErrors();
    $response->assertStatus(302);
    expect(IncomeCategory::all()->count())->toBe(1);
});

test('user cannot create category to another user', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $response = $this->actingAs($user1)
        ->post(route('income-categories.store'), ['name' => 'teste', 'user_id' => $user2->id]);

    $response->assertSessionHasNoErrors();
    $response->assertStatus(302);

    expect(IncomeCategory::query()->select('user_id')->first()->user_id)->toBe($user1->id);
});
