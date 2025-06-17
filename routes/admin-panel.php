<?php

use App\Http\Controllers\AdministrationPanelController;
use App\UserRoleEnum;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:' . UserRoleEnum::ADMIN->getName()])->group(function () {
    Route::get('admin-panel', [AdministrationPanelController::class, 'index'])->name('admin-panel.index');
    Route::post('admin-panel/status', [AdministrationPanelController::class, 'updateStatus'])->name('admin-panel.update-status');
});
