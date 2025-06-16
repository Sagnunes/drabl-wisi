<?php

use App\Http\Controllers\StatusController;
use App\UserRoleEnum;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:' . UserRoleEnum::ADMIN->getName()])->group(function () {
    Route::get('statuses', [StatusController::class, 'index'])->name('statuses.index');
    Route::post('statuses', [StatusController::class, 'store'])->name('statuses.store');
    Route::patch('statuses/{status}', [StatusController::class, 'update'])->name('statuses.update');
    Route::delete('statuses/{status:id}', [StatusController::class, 'destroy'])->name('statuses.destroy');
});
