<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/admin/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('demo', function () {
    return Inertia::render('Demo');
})->middleware(['auth', 'verified'])->name('demo');

require __DIR__.'/admin.php';
require __DIR__.'/client.php';
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
