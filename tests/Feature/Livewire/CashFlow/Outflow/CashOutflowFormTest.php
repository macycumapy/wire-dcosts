<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\CashFlow\Outflow;

use App\Actions\CashOutflowItem\Data\OutflowItemData;
use App\Enums\CashFlowType;
use App\Livewire\CashFlow\Outflow\CashOutflowCard;
use App\Models\CashFlow;
use App\Models\Category;
use App\Models\Nomenclature;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Livewire;
use Tests\TestCase;

class CashOutflowFormTest extends TestCase
{
    public function testCreate()
    {
        $this->actingAs($user = User::factory()->withBalance(100_000)->create());
        $date = now()->subDay();
        $category = Category::factory()->outflow()->for($user)->create();
        $nomenclature = Nomenclature::factory()->for($user)->create();

        Livewire::test(CashOutflowCard::class)
            ->set('data.date', $date)
            ->set('data.category_id', $category->id)
            ->call('addItem', OutflowItemData::from([
                'count' => 1,
                'cost' => 100,
                'user_id' => $user->id,
                'nomenclature_id' => $nomenclature->id
            ])->toArray())
            ->call('create')
            ->assertHasNoErrors()
            ->assertDispatched(CashOutflowCard::CASH_OUTFLOW_SAVED_EVENT);

        $this->assertTrue(
            CashFlow::query()
                ->where('user_id', $user->id)
                ->where('date', $date)
                ->where('category_id', $category->id)
                ->where('sum', 100)
                ->where('type', CashFlowType::Outflow)
                ->whereRelation('details', function (Builder $q) use ($nomenclature) {
                    $q->where('count', 1);
                    $q->where('cost', 100);
                    $q->where('nomenclature_id', $nomenclature->id);
                })
                ->exists()
        );
    }

    public function testUpdate()
    {
        $this->actingAs($user = User::factory()->withBalance(100_000)->create());
        $date = now()->subDay();
        $category = Category::factory()->outflow()->for($user)->create();
        $detailsCount = 3;
        /** @var CashFlow $cashFlow */
        $cashFlow = CashFlow::factory()->outflow($detailsCount)->for($user)->create();
        $addedItem = OutflowItemData::from([
            'count' => 1,
            'cost' => 100,
            'user_id' => $user->id,
            'nomenclature_id' => Nomenclature::factory()->for($user)->create()->id
        ]);
        $updatedItem = OutflowItemData::from([
            'id' => $cashFlow->details->first()->id,
            'count' => 2,
            'cost' => 222,
            'user_id' => $user->id,
            'nomenclature_id' => Nomenclature::factory()->for($user)->create()->id
        ]);

        Livewire::test(CashOutflowCard::class, ['id' => $cashFlow->id])
            ->set('data.date', $date)
            ->set('data.category_id', $category->id)
            ->call('addItem', $addedItem->toArray())
            ->call('updateItem', 0, $updatedItem->toArray())
            ->call('update')
            ->assertHasNoErrors()
            ->assertDispatched(CashOutflowCard::CASH_OUTFLOW_SAVED_EVENT);

        $cashFlow->refresh();

        $this->assertEquals(round($cashFlow->details->sum('sum'), 2), $cashFlow->sum);
        $this->assertEquals($date->toString(), $cashFlow->date->toString());
        $this->assertEquals($category->id, $cashFlow->category_id);
        $this->assertEquals($user->accounts->first()->id, $cashFlow->account_id);
        $this->assertEquals($detailsCount + 1, $cashFlow->details->count());
        $this->assertTrue(
            $cashFlow->details()
            ->where('count', $addedItem->count)
            ->where('cost', $addedItem->cost)
            ->where('nomenclature_id', $addedItem->nomenclature_id)
            ->exists()
        );
        $this->assertTrue(
            $cashFlow->details()
            ->where('count', $updatedItem->count)
            ->where('cost', $updatedItem->cost)
            ->where('nomenclature_id', $updatedItem->nomenclature_id)
            ->exists()
        );
    }

    public function testClone()
    {
        $this->actingAs($user = User::factory()->withBalance(100_000)->create());
        /** @var CashFlow $cashFlow */
        $cashFlow = CashFlow::factory()->for($user)->outflow()->create();
        Livewire::test(CashOutflowCard::class, ['id' => $cashFlow->id, 'clone' => true])
            ->call('create')
            ->assertHasNoErrors()
            ->assertDispatched(CashOutflowCard::CASH_OUTFLOW_SAVED_EVENT);
        $cashFlow->refresh();

        $this->assertSame(
            2,
            CashFlow::query()
                ->where('user_id', $user->id)
                ->where('category_id', $cashFlow->category_id)
                ->where('type', $cashFlow->type)
                ->where('account_id', $cashFlow->account_id)
                ->count()
        );
    }
}
