<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductSpecificationController;
use App\Http\Controllers\Admin\SpecificationController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SpecificationValueController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // User management
        Route::resource('users', UserController::class);

        // Specifications management
        Route::resource('specifications', SpecificationController::class);

        // Specification values
        Route::prefix('specifications/{specification}')->name('specifications.')->group(function () {
            Route::get('/values', [SpecificationValueController::class, 'index'])->name('values.index');
            Route::get('/values/create', [SpecificationValueController::class, 'create'])->name('values.create');
            Route::post('/values', [SpecificationValueController::class, 'store'])->name('values.store');
            Route::get('/values/{value}/edit', [SpecificationValueController::class, 'edit'])->name('values.edit');
            Route::put('/values/{value}', [SpecificationValueController::class, 'update'])->name('values.update');
            Route::delete('/values/{value}', [SpecificationValueController::class, 'destroy'])->name('values.destroy');
        });

        // Category management
        Route::resource('categories', CategoryController::class);

        // Category specifications management
        Route::get('/categories/{category}/specifications', [CategoryController::class, 'manageSpecifications'])->name('categories.specifications');
        Route::post('/categories/{category}/specifications', [CategoryController::class, 'updateSpecifications'])->name('categories.specifications.update');

        // Product management
        Route::resource('products', ProductController::class);

        // Product specifications
        Route::get('products/{product}/specifications', [ProductSpecificationController::class, 'index'])
            ->name('products.specifications.index');
        Route::get('products/{product}/specifications/create', [ProductSpecificationController::class, 'create'])
            ->name('products.specifications.create');
        Route::post('products/{product}/specifications', [ProductSpecificationController::class, 'store'])
            ->name('products.specifications.store');
        Route::get('products/{product}/specifications/{specification}', [ProductSpecificationController::class, 'show'])
            ->name('products.specifications.show');
        Route::get('products/{product}/specifications/{specification}/edit', [ProductSpecificationController::class, 'edit'])
            ->name('products.specifications.edit');
        Route::put('products/{product}/specifications/{specification}', [ProductSpecificationController::class, 'update'])
            ->name('products.specifications.update');
        Route::delete('products/{product}/specifications/{specification}', [ProductSpecificationController::class, 'destroy'])
            ->name('products.specifications.destroy');
    });
});

require __DIR__ . '/auth.php';
