<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirm_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $testResponse = $this->actingAs($user)->get('/confirm-password');

        $testResponse->assertStatus(200);
    }

    public function test_password_can_be_confirmed(): void
    {
        $user = User::factory()->create();

        $testResponse = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'password',
        ]);

        $testResponse->assertRedirect();
        $testResponse->assertSessionHasNoErrors();
    }

    public function test_password_is_not_confirmed_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $testResponse = $this->actingAs($user)->post('/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $testResponse->assertSessionHasErrors();
    }
}
