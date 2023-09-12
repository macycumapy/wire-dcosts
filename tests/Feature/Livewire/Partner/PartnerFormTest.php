<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Partner;

use App\Livewire\Partner\PartnerForm;
use App\Models\Partner;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class PartnerFormTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testCreate(string $name)
    {
        $this->actingAs($user = User::factory()->create());
        Livewire::test(PartnerForm::class)
            ->set('data.name', $name)
            ->call('create')
            ->assertHasNoErrors()
            ->assertDispatched(PartnerForm::PARTNER_SAVED_EVENT);

        $this->assertTrue(
            Partner::query()
                ->where('name', $name)
                ->where('user_id', $user->id)
                ->exists()
        );

    }

    /** @dataProvider dataProvider */
    public function testUpdate(string $name)
    {
        $this->actingAs($user = User::factory()->create());
        $partner = Partner::factory()->for($user)->create();

        Livewire::test(PartnerForm::class, ['id' => $partner->id])
            ->set('data.name', $name)
            ->call('update')
            ->assertHasNoErrors()
            ->assertDispatched(PartnerForm::PARTNER_SAVED_EVENT);

        $this->assertEquals($name, $partner->fresh()->name);
    }

    public static function dataProvider(): array
    {
        return [[
            'some name'
        ]];
    }
}
