<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\CashFlowType;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function search(Request $request)
    {
        return $request->exists('selected')
            ? Category::find($request->input('selected', []))
            : Category::ofType(CashFlowType::tryFrom($request->query('type', '')))->searchByName(
                $request->query('search', ''),
            )->get();
    }
}
