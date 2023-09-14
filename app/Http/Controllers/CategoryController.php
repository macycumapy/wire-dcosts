<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function search(Request $request)
    {
        return $request->exists('selected')
            ? Category::find($request->input('selected', []))
            : Category::searchByName(
                $request->query('search', ''),
            );
    }
}
