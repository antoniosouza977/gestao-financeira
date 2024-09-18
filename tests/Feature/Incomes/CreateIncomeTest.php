<?php

namespace Tests\Feature\Incomes;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia;
use JsonException;
use Tests\TestCase;

class CreateIncomeTest extends TestCase
{
    use RefreshDatabase;

    private Collection|Model $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $this->user = User::factory()->create();
    }

    public function test_form_can_be_rendered(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('incomes.create'));

        $response->assertStatus(200);
    }

    public function test_form_has_one_category(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('incomes.create'));

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('Incomes/Form')
                ->has('categories', 1);
        });

        $response->assertStatus(200);
    }

    public function test_required_validations(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('incomes.store'), [
                "value"        => null,
                "category_id"  => null,
                "payment_day" => null,
            ]);

        $response->assertSessionHasErrors(["value", "category_id", "payment_day"]);
        $response->assertStatus(302);
    }

    /**
     * @throws JsonException
     */
    public function test_user_can_create_an_income(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('incomes.store'), [
                "value"        => fake()->randomFloat(2),
                "category_id"  => 1,
                "description"  => fake()->text,
                "payment_day" => fake()->randomFloat(0,1,31),
            ]);

        $response->assertSessionHasNoErrors();
        $this->assertEquals(1, $this->user->incomes->count());
    }
}
