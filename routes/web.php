<?php

declare(strict_types=1);

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NomenclatureTypeController;
use App\Http\Controllers\PartnerController;
use App\Livewire\Auth\LoginForm;
use App\Livewire\Auth\RegisterForm;
use App\Livewire\CashFlow\Inflow\CashInflowCard;
use App\Livewire\Nomenclature\NomenclatureForm;
use App\Livewire\NomenclatureType\NomenclatureTypeForm;
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

    Route::prefix('nomenclature-types')->group(function () {
        Route::get('/search', [NomenclatureTypeController::class, 'search'])->name('nomenclature-type.search');
        Route::get('/create', NomenclatureTypeForm::class)->name('nomenclature-type.create');
        Route::get('/{id}', NomenclatureTypeForm::class)->name('nomenclature-type.edit');
    });

    Route::prefix('nomenclatures')->group(function () {
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
});
