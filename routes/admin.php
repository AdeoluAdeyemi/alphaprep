<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {

    // // Dashboard
    // Route::get('/dashboard', function () {
    //     return Inertia::render('Dashboard');
    // })->name('admin.dashboard');


    Route::get('categories', function () {
        return Inertia::render('admin/Categories');
    })->middleware(['auth', 'verified'])->name('admin.categories');
    // // Examination Category
    // Route::resource('categories', CategoryController::class)
    //     ->only(['index', 'create', 'store', 'edit', 'update', 'destroy'])
    //     ->names('admin.categories');


    Route::get('providers', function () {
        return Inertia::render('admin/Providers');
    })->middleware(['auth', 'verified'])->name('admin.providers');
    // // Examination Type
    // Route::resource('providers', ProviderController::class)
    //     ->only(['index','create','store','edit','update','destroy'])
    //     ->names('admin.providers');


    Route::get('exams', function () {
        return Inertia::render('admin/Exams');
    })->middleware(['auth', 'verified'])->name('admin.exams');
    // // Examination
    // Route::resource('exams', ExamController::class)
    //     ->only(['index','create','store','edit','update','destroy'])
    //     ->names('admin.exams');


    Route::get('questions', function () {
        return Inertia::render('admin/Questions');
    })->middleware(['auth', 'verified'])->name('admin.questions');
    // // Questions
    // Route::resource('questions', QuestionController::class)
    //     ->only(['index','create','store','edit','update','destroy'])
    //     ->names('admin.questions');

    Route::get('users', function () {
        return Inertia::render('admin/Users');
    })->middleware(['auth', 'verified'])->name('admin.users');
    // // User Management
    // Route::resource('users', UserController::class)
    //     ->only(['index','create','store'])
    //     ->names('admin.users');

    // /**
    //  * Access Control List - Roles and Permission
    //  */

    // // Permissions
    // Route::resource('permissions', PermissionController::class)
    // ->only(['index','create','store','edit','update','destroy'])
    // ->names('admin.permissions');

    // // Roles
    // Route::resource('roles', RoleController::class)
    // ->only(['index','create','store','edit','update','destroy'])
    // ->names('admin.roles');

    // // Role Permissions
    // Route::resource('role-permission', RolePermissionController::class)
    // ->only(['edit','update'])
    // ->names('admin.role-permission');


    // /**
    //  * Tickets - Categories and Labels
    //  */

    // // Tickets
    // Route::resource('tickets', TicketController::class)
    // ->only(['index','create','store','edit','update','destroy'])
    // ->names('admin.tickets');

    // // Categories
    // Route::resource('tickets/categories', TicketCategoryController::class)
    // ->only(['index','create','store','edit','update','destroy'])
    // ->names('admin.tickets.categories');

    // // Labels
    // Route::resource('tickets/labels', TicketLabelController::class)
    // ->only(['index','create','store','edit','update','destroy'])
    // ->names('admin.tickets.labels');

    // // Route::resource('users', UserController::class);
    // // Route::get('users/{userId}/delete', [UserController::class, 'destroy']);

    // // Route for feedback
    // Route::resource('feedbacks', FeedbackController::class)
    // ->only(['index','edit','update'])
    // ->names('admin.feedback');
});
