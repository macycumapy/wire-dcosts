<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function search(Request $request)
    {
        return $request->exists('selected')
            ? Partner::find($request->input('selected', []))
            : Partner::searchByName(
                $request->query('search', ''),
            );
    }
}
