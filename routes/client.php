<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('dashboard', function () {
    return Inertia::render('client/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('exam', function () {
    return Inertia::render('client/exam/Exam');
})->middleware(['auth', 'verified'])->name('exam');


Route::get('practice', function () {
    return Inertia::render('client/exam/Practice');
})->middleware(['auth', 'verified'])->name('practice');

Route::get('subscriptions', function () {
    return Inertia::render('client/Subscriptions');
})->middleware(['auth', 'verified'])->name('subscriptions');
