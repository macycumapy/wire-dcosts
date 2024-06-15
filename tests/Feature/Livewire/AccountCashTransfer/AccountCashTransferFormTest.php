<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\AccountCashTransfer;

use App\Livewire\AccountCashTransfer\AccountCashTransferForm;
use App\Models\Account;
use App\Models\AccountCashTransfer;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class AccountCashTransferFormTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testCreate(float $accountFromBalance, float $accountToBalance, float $transferSum): void
    {
        $this->actingAs($user = User::factory()->create());

        $accountFrom = Account::factory()->for($user)->create(['balance' => $accountFromBalance]);
        $accountTo = Account::factory()->for($user)->create(['balance' => $accountToBalance]);

        Livewire::test(AccountCashTransferForm::class)
            ->set('data.sum', $transferSum)
            ->set('data.from_account_id', $accountFrom->id)
            ->set('data.to_account_id', $accountTo->id)
            ->call('create')
            ->assertHasNoErrors()
            ->assertDispatched(AccountCashTransferForm::ACCOUNT_CASH_TRANSFER_SAVED);

        $accountFrom->refresh();
        $accountTo->refresh();

        $this->assertTrue(
            AccountCashTransfer::query()
                ->where('from_account_id', $accountFrom->id)
                ->where('to_account_id', $accountTo->id)
                ->where('sum', $transferSum)
                ->where('user_id', $user->id)
                ->exists()
        );

        $this->assertEquals($accountFromBalance - $transferSum, $accountFrom->balance);
        $this->assertEquals($accountToBalance + $transferSum, $accountTo->balance);
    }

    public static function dataProvider(): array
    {
        return [[
            200.00,
            222.00,
            111.00,
        ]];
    }
}
