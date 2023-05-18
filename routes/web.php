<?php

declare(strict_types=1);

use App\Http\Livewire\Auth\RegisterForm;
use Illuminate\Support\Facades\Route;

Route::get('/register', RegisterForm::class)->name('register');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
