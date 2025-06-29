<?php


use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    require __DIR__ . '/status.php';
    require __DIR__ . '/role.php';
    require __DIR__ . '/fund.php';
    require __DIR__ . '/digital-collection.php';
    require __DIR__ . '/admin-panel.php';
});


require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';


