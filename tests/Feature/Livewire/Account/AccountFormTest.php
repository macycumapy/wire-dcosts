<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Account;

use App\Livewire\Account\AccountForm;
use App\Models\Account;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class AccountFormTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testCreate(string $name, string $comment)
    {
        $this->actingAs($user = User::factory()->create());
        Livewire::test(AccountForm::class)
            ->set('data.name', $name)
            ->set('data.comment', $comment)
            ->call('create')
            ->assertHasNoErrors()
            ->assertDispatched(AccountForm::ACCOUNT_SAVED_EVENT);

        $this->assertTrue(
            Account::query()
                ->where('name', $name)
                ->where('comment', $comment)
                ->where('user_id', $user->id)
                ->exists()
        );

    }

    /** @dataProvider dataProvider */
    public function testUpdate(string $name, string $comment)
    {
        $account = Account::factory()->create();

        $this->actingAs($account->user);
        Livewire::test(AccountForm::class, ['id' => $account->id])
            ->set('data.name', $name)
            ->set('data.comment', $comment)
            ->call('update')
            ->assertHasNoErrors()
            ->assertDispatched(AccountForm::ACCOUNT_SAVED_EVENT);

        $account->refresh();
        $this->assertEquals($name, $account->name);
        $this->assertEquals($comment, $account->comment);
    }

    public static function dataProvider(): array
    {
        return [[
            'name' => 'some name',
            'comment' => 'some comment',
        ]];
    }
}
