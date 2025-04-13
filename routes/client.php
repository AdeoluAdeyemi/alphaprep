<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('exam', function () {
    return Inertia::render('client/Exam');
})->middleware(['auth', 'verified'])->name('exam');


Route::get('practice', function () {
    return Inertia::render('client/Exam/Practice');
})->middleware(['auth', 'verified'])->name('practice');
