<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Nomenclature;
use Illuminate\Http\Request;

class NomenclatureController extends Controller
{
    public function search(Request $request)
    {
        return $request->exists('selected')
            ? Nomenclature::find($request->input('selected', []))
            : Nomenclature::searchByName(
                $request->query('search', ''),
            );
    }
}
