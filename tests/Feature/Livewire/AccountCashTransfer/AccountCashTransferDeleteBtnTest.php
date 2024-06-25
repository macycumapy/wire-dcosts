<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\AccountCashTransfer;

use App\Livewire\AccountCashTransfer\AccountCashTransferDeleteButton;
use App\Models\Account;
use App\Models\AccountCashTransfer;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class AccountCashTransferDeleteBtnTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testCreate(float $accountFromBalance, float $accountToBalance, float $transferSum): void
    {
        $this->actingAs($user = User::factory()->create());

        $accountFrom = Account::factory()->for($user)->create(['balance' => $accountFromBalance]);
        $accountTo = Account::factory()->for($user)->create(['balance' => $accountToBalance]);

        $accountCashTransfer = AccountCashTransfer::factory()
            ->for($user)
            ->for($accountFrom, 'fromAccount')
            ->for($accountTo, 'toAccount')
            ->create(['sum' => $transferSum]);

        Livewire::test(AccountCashTransferDeleteButton::class, ['cashTransfer' => $accountCashTransfer])
            ->call('delete')
            ->assertHasNoErrors()
            ->assertDispatched(AccountCashTransferDeleteButton::ACCOUNT_CASH_TRANSFER_DELETED);

        $accountFrom->refresh();
        $accountTo->refresh();

        $this->assertSoftDeleted($accountCashTransfer);

        $this->assertEquals($accountFromBalance + $transferSum, $accountFrom->balance);
        $this->assertEquals($accountToBalance - $transferSum, $accountTo->balance);
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
