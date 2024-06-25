<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\AccountCashTransfer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AccountCashTransfer>
 */
class AccountCashTransferFactory extends Factory
{
    public function definition(): array
    {
        return [
            'sum' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
