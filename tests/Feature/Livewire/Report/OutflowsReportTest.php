<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Report;

use App\Livewire\Report\OutflowsReport;
use App\Models\CashFlow;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class OutflowsReportTest extends TestCase
{
    private ?User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs($this->user = User::factory()->create());
    }

    public function testCanSee()
    {
        $this->get(route('report.outflows'))
            ->assertSeeLivewire(OutflowsReport::class);
    }

    public function testEmptyResult()
    {
        Livewire::test(OutflowsReport::class)
            ->assertSee(OutflowsReport::NO_DATA_FOUND_TEXT);
    }

    public function testValidResult()
    {
        /** @var CashFlow $cashFlow */
        $cashFlow = CashFlow::factory()->for($this->user)->outflow()->create();

        $component = Livewire::test(OutflowsReport::class)
            ->assertDontSee(OutflowsReport::NO_DATA_FOUND_TEXT)
            ->assertSee($cashFlow->category->name);

        $cashFlow->loadMissing('details.nomenclature');
        foreach ($cashFlow->details as $detail) {
            $component->assertSee($detail->nomenclature->name);
        }
    }
}
