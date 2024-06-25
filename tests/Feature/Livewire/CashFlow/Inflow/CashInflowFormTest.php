<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\CashFlow\Inflow;

use App\Enums\CashFlowType;
use App\Livewire\CashFlow\Inflow\CashInflowCard;
use App\Models\CashFlow;
use App\Models\Category;
use App\Models\Partner;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class CashInflowFormTest extends TestCase
{
    public function testCreate()
    {
        $this->actingAs($user = User::factory()->create());
        $date = now()->subDay();
        $partner = Partner::factory()->for($user)->create();
        $category = Category::factory()->inflow()->for($user)->create();
        $sum = 111;

        Livewire::test(CashInflowCard::class)
            ->set('data.sum', $sum)
            ->set('data.date', $date)
            ->set('data.partner_id', $partner->id)
            ->set('data.category_id', $category->id)
            ->call('create')
            ->assertHasNoErrors()
            ->assertDispatched(CashInflowCard::CASH_INFLOW_CREATED_EVENT);

        $this->assertTrue(
            CashFlow::query()
                ->where('user_id', $user->id)
                ->where('type', CashFlowType::Inflow)
                ->where('sum', $sum)
                ->exists()
        );
    }

    public function testUpdate()
    {
        $this->actingAs($user = User::factory()->create());
        $date = now()->subDay();
        $partner = Partner::factory()->for($user)->create();
        $category = Category::factory()->inflow()->for($user)->create();
        $cashFlow = CashFlow::factory()->inflow()->for($user)->create();
        $sum = 111;

        Livewire::test(CashInflowCard::class, ['id' => $cashFlow->id])
            ->set('data.sum', $sum)
            ->set('data.date', $date)
            ->set('data.partner_id', $partner->id)
            ->set('data.category_id', $category->id)
            ->call('update')
            ->assertHasNoErrors()
            ->assertDispatched(CashInflowCard::CASH_INFLOW_CREATED_EVENT);

        $cashFlow->refresh();

        $this->assertEquals($sum, $cashFlow->sum);
        $this->assertEquals($date->toString(), $cashFlow->date->toString());
        $this->assertEquals($partner->id, $cashFlow->partner_id);
        $this->assertEquals($category->id, $cashFlow->category_id);
        $this->assertEquals($user->mainAccount->id, $cashFlow->account_id);
        $this->assertEquals($sum, CashFlow::getBalance());
        $this->assertEquals($sum, $cashFlow->account->balance);
    }

    public function testClone()
    {
        $this->actingAs($user = User::factory()->create());
        /** @var CashFlow $cashFlow */
        $cashFlow = CashFlow::factory()->for($user)->inflow()->create();
        Livewire::test(CashInflowCard::class, ['id' => $cashFlow->id, 'clone' => true])
            ->call('create')
            ->assertHasNoErrors()
            ->assertDispatched(CashInflowCard::CASH_INFLOW_CREATED_EVENT);
        $cashFlow->refresh();

        $this->assertSame(
            2,
            CashFlow::query()
                ->where('user_id', $cashFlow->user_id)
                ->where('type', $cashFlow->type)
                ->where('sum', $cashFlow->sum)
                ->where('partner_id', $cashFlow->partner_id)
                ->where('category_id', $cashFlow->category_id)
                ->where('account_id', $cashFlow->account_id)
                ->count()
        );

        $this->assertEquals($cashFlow->sum * 2, $cashFlow->account->balance);
        $this->assertEquals($cashFlow->sum * 2, CashFlow::getBalance());
    }
}
