<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\User\Data\CreateUserData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function exec(CreateUserData $createUserData): User
    {
        $newUser = new User();
        $newUser->name = $createUserData->name;
        $newUser->email = $createUserData->email;
        $newUser->password = Hash::make($createUserData->password);
        $newUser->save();

        return $newUser;
    }
}
