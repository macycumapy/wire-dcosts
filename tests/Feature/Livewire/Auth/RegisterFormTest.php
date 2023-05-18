<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Auth;

use App\Actions\User\Data\CreateUserData;
use App\Http\Livewire\Auth\RegisterForm;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterFormTest extends TestCase
{
    public function testSeeComponent(): void
    {
        $this->get(route('register'))
            ->assertSuccessful()
            ->assertSeeLivewire(RegisterForm::class);
    }

    /**
     * @dataProvider validRegisterDataProvider
     */
    public function testValidRegister($data)
    {
        /** @var CreateUserData $createUserData */
        $createUserData = $data();

        Livewire::test(RegisterForm::class)
            ->set('createUserData', $createUserData)
            ->call('register')
            ->assertHasNoErrors();

        $this->assertNotNull($user = User::firstWhere([
            'name' => trim($createUserData->name),
            'email' => trim($createUserData->email),
        ]));

        $this->assertTrue(Hash::check($createUserData->password, trim($user->password)));
    }

    public static function validRegisterDataProvider(): array
    {
        return [
            'data' => [
                fn () => CreateUserData::from([
                    'name' => 'some name',
                    'email' => 'some@email.ru',
                    'password' => 'pass',
                    'password_confirmation' => 'pass',
                ]),
            ],
            'data with trim' => [
                fn () => CreateUserData::from([
                    'name' => '  some name  ',
                    'email' => '  some@email.ru  ',
                    'password' => '  pass ',
                    'password_confirmation' => '  pass ',
                ]),
            ]
        ];
    }
}
