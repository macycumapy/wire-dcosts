<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Report;

use App\Livewire\Report\InflowsReport;
use App\Models\CashFlow;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class InflowsReportTest extends TestCase
{
    private ?User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->actingAs($this->user = User::factory()->create());
    }

    public function testCanSee()
    {
        $this->get(route('report.inflows'))
            ->assertSeeLivewire(InflowsReport::class);
    }

    public function testEmptyResult()
    {
        Livewire::test(InflowsReport::class)
            ->assertSee(InflowsReport::NO_DATA_FOUND_TEXT);
    }

    public function testValidResult()
    {
        /** @var CashFlow $cashFlow */
        $cashFlow = CashFlow::factory()->for($this->user)->inflow()->create();

        Livewire::test(InflowsReport::class)
            ->assertDontSee(InflowsReport::NO_DATA_FOUND_TEXT)
            ->assertSee($cashFlow->category->name)
            ->assertSee($cashFlow->partner->name);
    }
}
