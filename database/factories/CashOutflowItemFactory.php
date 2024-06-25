<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\CashOutflowItem;
use App\Models\Nomenclature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CashOutflowItem>
 */
class CashOutflowItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'count' => $this->faker->numberBetween(1, 10),
            'cost' => $this->faker->randomFloat(2, 1, 1000),
            'nomenclature_id' => Nomenclature::factory()->create(),
        ];
    }
}
