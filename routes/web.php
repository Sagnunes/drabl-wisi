<?php

use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';

Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
Route::patch('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
Route::delete('roles/{role:id}', [RoleController::class, 'destroy'])->name('roles.destroy');
