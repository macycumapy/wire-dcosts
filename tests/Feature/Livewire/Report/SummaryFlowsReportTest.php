<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Report;

use App\Livewire\Report\SummaryFlowsReport;
use App\Models\CashFlow;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class SummaryFlowsReportTest extends TestCase
{
    private ?User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs($this->user = User::factory()->create());
    }

    public function testCanSee()
    {
        $this->get(route('report.summary-flows'))
            ->assertSeeLivewire(SummaryFlowsReport::class);
    }

    public function testValidResult()
    {
        /** @var CashFlow $cashFlow */
        $cashOutflow = CashFlow::factory()->for($this->user)->outflow()->create();
        $cashInflow = CashFlow::factory()->for($this->user)->inflow()->create();

        Livewire::test(SummaryFlowsReport::class)
            ->assertSee(number_format($cashOutflow->sum, 2, '.', ' '))
            ->assertSee(number_format($cashInflow->sum, 2, '.', ' '));
    }
}
