<?php


use App\Http\Controllers\RoleController;
use App\UserRoleEnum;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','role:'.UserRoleEnum::ADMIN->getName()])->group(function () {
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    Route::patch('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{role:id}', [RoleController::class, 'destroy'])->name('roles.destroy');
});
