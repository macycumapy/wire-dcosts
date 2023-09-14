<?php

declare(strict_types=1);

namespace Feature\Livewire\CashFlow\Inflow;

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

        Livewire::test(CashInflowCard::class)
            ->set('data.sum', 111)
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
                ->exists()
        );
    }
}
