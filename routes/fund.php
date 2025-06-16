<?php

use App\Http\Controllers\FundController;
use App\UserRoleEnum;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:' . UserRoleEnum::ADMIN->getName()])->group(function () {
    Route::get('funds', [FundController::class, 'index'])->name('funds.index');
    Route::post('funds', [FundController::class, 'store'])->name('funds.store');
    Route::patch('funds/{fund}', [FundController::class, 'update'])->name('funds.update');
    Route::delete('funds/{fund:id}', [FundController::class, 'destroy'])->name('funds.destroy');
});
