<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CashFlowType;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(CashFlowType::values()),
            'user_id' => User::factory()->create(),
        ];
    }

    public function withType(CashFlowType $type): Factory
    {
        return $this->state(function (array $attributes) use ($type) {
            return [
                'type' => $type,
            ];
        });
    }

    public function outflow(): Factory
    {
        return $this->withType(CashFlowType::Outflow);
    }

    public function inflow(): Factory
    {
        return $this->withType(CashFlowType::Inflow);
    }
}
