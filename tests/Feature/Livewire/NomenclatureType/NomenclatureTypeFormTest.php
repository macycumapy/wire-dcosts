<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\NomenclatureType;

use App\Livewire\NomenclatureType\NomenclatureTypeForm;
use App\Models\NomenclatureType;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class NomenclatureTypeFormTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testCreate(string $name)
    {
        $this->actingAs($user = User::factory()->create());
        Livewire::test(NomenclatureTypeForm::class)
            ->set('data.name', $name)
            ->call('create')
            ->assertHasNoErrors()
            ->assertDispatched(NomenclatureTypeForm::NOMENCLATURE_TYPE_SAVED_EVENT);

        $this->assertTrue(
            NomenclatureType::query()
                ->where('name', $name)
                ->where('user_id', $user->id)
                ->exists()
        );

    }

    /** @dataProvider dataProvider */
    public function testUpdate(string $name)
    {
        $this->actingAs($user = User::factory()->create());
        $nomType = NomenclatureType::factory()->for($user)->create();

        Livewire::test(NomenclatureTypeForm::class, ['id' => $nomType->id])
            ->set('data.name', $name)
            ->call('update')
            ->assertHasNoErrors()
            ->assertDispatched(NomenclatureTypeForm::NOMENCLATURE_TYPE_SAVED_EVENT);

        $this->assertEquals($name, $nomType->fresh()->name);
    }

    public static function dataProvider(): array
    {
        return [[
            'some name'
        ]];
    }
}
