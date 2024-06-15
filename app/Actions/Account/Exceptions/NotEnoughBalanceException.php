<?php

declare(strict_types=1);

namespace App\Actions\Account\Exceptions;

use Exception;

class NotEnoughBalanceException extends Exception
{
    protected $message = 'На счету недостаточно средств';
}
