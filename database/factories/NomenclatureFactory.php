<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Nomenclature;
use App\Models\NomenclatureType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Nomenclature>
 */
class NomenclatureFactory extends Factory
{
    public function definition(): array
    {
        $user = User::factory()->create();

        return [
            'name' => $this->faker->name(),
            'user_id' => $user,
            'nomenclature_type_id' => NomenclatureType::factory()->for($user)->create(),
        ];
    }
}
