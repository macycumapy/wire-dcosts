<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CashFlowType;
use App\Models\CashFlow;
use App\Models\Category;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CashFlow>
 */
class CashFlowFactory extends Factory
{
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'date' => now(),
            'sum' => 500,
            'category_id' => Category::factory()->for($user)->create(),
            'partner_id' => Partner::factory()->for($user)->create(),
            'user_id' => $user,
            'type' => $this->faker->randomElement(CashFlowType::values()),
        ];
    }

    public function outflow(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => CashFlowType::Outflow,
                'category_id' => Category::factory()->outflow()->create([
                    'user_id' => $attributes['user_id'],
                ]),
                'partner_id' => Partner::factory()->create([
                    'user_id' => $attributes['user_id'],
                ]),
            ];
        });
    }

    public function inflow(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => CashFlowType::Inflow,
                'category_id' => Category::factory()->inflow()->create([
                    'user_id' => $attributes['user_id'],
                ]),
                'partner_id' => Partner::factory()->create([
                    'user_id' => $attributes['user_id'],
                ]),
            ];
        });
    }
}
