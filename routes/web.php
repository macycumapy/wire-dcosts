<?php

declare(strict_types=1);

use App\Http\Controllers\NomenclatureTypeController;
use App\Livewire\Auth\LoginForm;
use App\Livewire\Auth\RegisterForm;
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
});
