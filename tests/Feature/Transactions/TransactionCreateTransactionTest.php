<?php

declare(strict_types=1);

use App\Models\Transaction;
use App\Models\User;

use function Pest\Laravel\actingAs;

test('user cant create a zero value transaction', function (): void {
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('expenses.store'), [
            'date' => now()->format('Y-m-d'),
            'value' => 0,
        ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['value']);

    actingAs($user)
        ->post(route('incomes.store'), [
            'date' => now()->format('Y-m-d'),
            'value' => 0,
        ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['value']);
});

test('user cant create a negative value transaction', function (): void {
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('expenses.store'), [
            'date' => now()->format('Y-m-d'),
            'value' => -1,
        ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['value']);

    actingAs($user)
        ->post(route('incomes.store'), [
            'date' => now()->format('Y-m-d'),
            'value' => -1,
        ])
        ->assertStatus(302)
        ->assertSessionHasErrors(['value']);
});

test('user can create a transaction', function (): void {
    $user = User::factory()->create();

    actingAs($user)
        ->post(route('expenses.store'), [
            'date' => now()->format('Y-m-d'),
            'value' => '10.50',
        ])
        ->assertStatus(302)
        ->assertSessionHasNoErrors();
    expect(Transaction::query()->where('type', 2)->count())->toBe(1);

    actingAs($user)
        ->post(route('incomes.store'), [
            'date' => now()->format('Y-m-d'),
            'value' => '10.50',
        ])
        ->assertStatus(302)
        ->assertSessionHasNoErrors();
    expect(Transaction::query()->where('type', 1)->count())->toBe(1);
});
