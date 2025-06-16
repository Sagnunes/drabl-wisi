<?php

use App\Http\Controllers\DigitalCollectionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:' . \App\UserRoleEnum::DIGITAL_COLLECTION->getName()])->group(function () {
    Route::get('colecao-digital', [DigitalCollectionController::class, 'index'])->name('digital-collection');
    Route::get('digital-collection/{fund:id}', [DigitalCollectionController::class, 'show'])->name('digital-collection.show');
});
