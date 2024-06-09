<?php

declare(strict_types=1);

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NomenclatureController;
use App\Http\Controllers\NomenclatureTypeController;
use App\Http\Controllers\PartnerController;
use App\Livewire\Account\AccountList;
use App\Livewire\Auth\LoginForm;
use App\Livewire\Auth\RegisterForm;
use App\Livewire\CashFlow\Inflow\CashInflowCard;
use App\Livewire\CashFlow\Outflow\CashOutflowCard;
use App\Livewire\InitBalances\InitBalancesForm;
use App\Livewire\Nomenclature\NomenclatureForm;
use App\Livewire\NomenclatureType\NomenclatureTypeForm;
use App\Livewire\Report\MetabaseReport;
use App\Livewire\Report\NomenclatureReport;
use App\Livewire\Report\OutflowsReport;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', RegisterForm::class)->name('register');
    Route::get('/login', LoginForm::class)->name('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('accounts')->group(function () {
        Route::get('/', AccountList::class)->name('accounts.list');
    });

    Route::prefix('nomenclature-types')->group(function () {
        Route::get('/search', [NomenclatureTypeController::class, 'search'])->name('nomenclature-type.search');
        Route::get('/create', NomenclatureTypeForm::class)->name('nomenclature-type.create');
        Route::get('/{id}', NomenclatureTypeForm::class)->name('nomenclature-type.edit');
    });

    Route::prefix('nomenclatures')->group(function () {
        Route::get('/search', [NomenclatureController::class, 'search'])->name('nomenclatures.search');
        Route::get('/create', NomenclatureForm::class)->name('nomenclatures.create');
        Route::get('/{id}', NomenclatureForm::class)->name('nomenclatures.edit');
    });

    Route::prefix('partners')->group(function () {
        Route::get('/search', [PartnerController::class, 'search'])->name('partners.search');
    });

    Route::prefix('categories')->group(function () {
        Route::get('/search', [CategoryController::class, 'search'])->name('categories.search');
    });

    Route::prefix('inflows')->group(function () {
        Route::get('/create', CashInflowCard::class)->name('inflows.create');
        Route::get('/{id}', CashInflowCard::class)->name('inflows.edit');
    });

    Route::prefix('outflows')->group(function () {
        Route::get('/create', CashOutflowCard::class)->name('outflows.create');
        Route::get('/{id}', CashOutflowCard::class)->name('outflows.edit');
    });

    Route::prefix('reports')->group(function () {
        Route::get('/outflows', OutflowsReport::class)->name('report.outflows');
        Route::get('/nomenclature/{id}', NomenclatureReport::class)->name('report.nomenclature');
        Route::get('/{slug}', MetabaseReport::class)->name('report');
    });

    Route::get('/init-balances', InitBalancesForm::class)->name('init-balances');
});
