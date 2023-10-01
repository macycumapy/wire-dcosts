<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\NomenclatureType;
use Illuminate\Http\Request;

class NomenclatureTypeController extends Controller
{
    public function search(Request $request)
    {
        return $request->exists('selected')
            ? NomenclatureType::find($request->input('selected', []))
            : NomenclatureType::searchByName(
                $request->query('search', ''),
            )->get();
    }
}
