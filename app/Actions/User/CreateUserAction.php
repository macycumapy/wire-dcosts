<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\User\Data\CreateUserData;
use App\Models\User;
use App\Services\DefaultDataFillers\DefaultDataFiller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

readonly class CreateUserAction
{
    public function __construct(private DefaultDataFiller $dataFiller)
    {
    }

    public function exec(CreateUserData $createUserData): User
    {
        return DB::transaction(function () use ($createUserData) {
            $newUser = new User();
            $newUser->name = $createUserData->name;
            $newUser->email = mb_strtolower($createUserData->email);
            $newUser->password = Hash::make($createUserData->password);
            $newUser->save();

            $this->dataFiller->fill($newUser);

            return $newUser;
        });
    }
}
