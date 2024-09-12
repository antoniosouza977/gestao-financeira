<?php

use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;

uses(RefreshDatabase::class);

it('renders the edit income form with the correct data', function () {
    $user = User::factory()->create();
    $category = IncomeCategory::factory()->create(['user_id' => $user->id]);
    $income = Income::factory()->create([
        'user_id'     => $user->id,
        'category_id' => $category->id,
    ]);

    $this->actingAs($user)
        ->get(route('incomes.edit', $income))
        ->assertInertia(fn(AssertableInertia $page) => $page
            ->component('Incomes/IncomesForm')
            ->has('income')
            ->has('categories', 1)
        );
});

it('updates the income and redirects to index', function () {
    $user = User::factory()->create();
    $category = IncomeCategory::factory()->create(['user_id' => $user->id]);
    $income = Income::factory()->create([
        'user_id'     => $user->id,
        'category_id' => $category->id,
    ]);

    $data = [
        'value'        => 1000,
        'category_id'  => 1,
        'payment_day' => 10,
        'description'  => 'Updated description',
    ];

    $this->actingAs($user)
        ->patch(route('incomes.update', $income), $data)
        ->assertRedirect(route('incomes.index'));

    $this->assertDatabaseHas('incomes', $data);
});

it('returns validation errors if update fails', function () {
    $user = User::factory()->create();
    $category = IncomeCategory::factory()->create(['user_id' => $user->id]);
    $income = Income::factory()->create([
        'user_id'     => $user->id,
        'category_id' => $category->id,
    ]);

    $data = [
        'value'        => null, // Invalid data
        'category_id'  => 1,
        'payment_day' => 'invalid-date',
        'description'  => 'Updated description',
    ];

    $this->actingAs($user)
        ->patch(route('incomes.update', $income), $data)
        ->assertSessionHasErrors(['value', 'payment_day']);
});

it('user cannot update income from another user', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $category = IncomeCategory::factory()->create(['user_id' => $user1->id]);
    $income = Income::factory()->create([
        'user_id'     => $user1->id,
        'category_id' => $category->id,
    ]);

    $data = [
        'value' => 1,
    ];

    $this->actingAs($user2)
        ->patch(route('incomes.update', $income), $data)
        ->assertSessionHasErrors(['user_id']);

    expect(Income::query()->find($income->id)->value === $income->value)->toBeTrue();
});

