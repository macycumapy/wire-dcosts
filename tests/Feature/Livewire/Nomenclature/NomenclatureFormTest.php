<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Nomenclature;

use App\Livewire\Nomenclature\NomenclatureForm;
use App\Models\Nomenclature;
use App\Models\NomenclatureType;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class NomenclatureFormTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testCreate(string $name)
    {
        $this->actingAs($user = User::factory()->create());
        Livewire::test(NomenclatureForm::class)
            ->set('data.name', $name)
            ->call('create')
            ->assertHasNoErrors()
            ->assertDispatched(NomenclatureForm::NOMENCLATURE_SAVED_EVENT);

        $this->assertTrue(
            Nomenclature::query()
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
        $nomenclature = Nomenclature::factory()->for($user)->create();

        Livewire::test(NomenclatureForm::class, ['id' => $nomenclature->id])
            ->set('data.name', $name)
            ->set('data.nomenclature_type_id', $nomType->id)
            ->call('update')
            ->assertHasNoErrors()
            ->assertDispatched(NomenclatureForm::NOMENCLATURE_SAVED_EVENT);

        $nomenclature->refresh();
        $this->assertEquals($name, $nomenclature->name);
        $this->assertEquals($nomType->id, $nomenclature->nomenclature_type_id);
    }

    public static function dataProvider(): array
    {
        return [[
            'some name'
        ]];
    }
}
