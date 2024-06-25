<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\CashFlow;

use App\Livewire\CashFlow\CashFlowDeleteButton;
use App\Models\CashFlow;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class CashFlowDeleteButtonTest extends TestCase
{
    public function testDelete()
    {
        $this->actingAs($user = User::factory()->withBalance(100_000)->create());
        $cashFlow = CashFlow::factory()->for($user)->create();
        $this->assertNotSoftDeleted($cashFlow);

        Livewire::test(CashFlowDeleteButton::class, ['cashFlow' => $cashFlow])
            ->call('delete')
            ->assertHasNoErrors()
            ->assertDispatched(CashFlowDeleteButton::CASH_FLOW_DELETED_EVENT);

        $this->assertSoftDeleted($cashFlow->fresh());
    }
}
