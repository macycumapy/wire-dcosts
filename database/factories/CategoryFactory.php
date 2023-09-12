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
}
