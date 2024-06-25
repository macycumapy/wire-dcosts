<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Services\DefaultDataFillers\DefaultDataFiller;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'timezone' => '+5',
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function (User $user) {
            app(DefaultDataFiller::class)->fill($user);
        });
    }

    public function withBalance(float $sum): self
    {
        return $this->afterCreating(function (User $user) use ($sum) {
            $account = $user->mainAccount;
            $account->balance = $sum;
            $account->save();
        });
    }
}
