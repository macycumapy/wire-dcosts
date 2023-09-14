<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Category;

use App\Enums\CashFlowType;
use App\Livewire\Category\CategoryForm;
use App\Models\Category;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class CategoryFormTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testCreate(string $name, CashFlowType $type)
    {
        $this->actingAs($user = User::factory()->create());
        Livewire::test(CategoryForm::class)
            ->set('data.name', $name)
            ->set('data.type', $type->value)
            ->call('create')
            ->assertHasNoErrors()
            ->assertDispatched(CategoryForm::CATEGORY_SAVED_EVENT);

        $this->assertTrue(
            Category::query()
                ->where('name', $name)
                ->where('user_id', $user->id)
                ->where('type', $type)
                ->exists()
        );

    }

    /** @dataProvider dataProvider */
    public function testUpdate(string $name)
    {
        $this->actingAs($user = User::factory()->create());
        $category = Category::factory()->for($user)->create();

        Livewire::test(CategoryForm::class, ['id' => $category->id])
            ->set('data.name', $name)
            ->call('update')
            ->assertHasNoErrors()
            ->assertDispatched(CategoryForm::CATEGORY_SAVED_EVENT);

        $category->refresh();
        $this->assertEquals($name, $category->name);
    }

    public static function dataProvider(): array
    {
        return [
            'outflow' => [
                'some outflow name',
                CashFlowType::Outflow,
            ],
            'inflow' => [
                'some inflow name',
                CashFlowType::Inflow,
            ]
        ];
    }
}
