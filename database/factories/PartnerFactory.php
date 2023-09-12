<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Partner>
 */
class PartnerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'user_id' => User::factory()->create(),
        ];
    }
}
