<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function search(Request $request)
    {
        return $request->exists('selected')
            ? Account::find($request->input('selected', []))
            : Account::searchByName($request->query('search', ''))->get();
    }
}
