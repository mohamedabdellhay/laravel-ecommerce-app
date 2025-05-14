<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\HomepageBlockController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// User routes (localhost)
Route::domain('localhost')->group(function () {
    Route::get('/', [HomepageController::class, 'index'])->name('home');

    // Add your user routes here
});

// Admin routes (admin.localhost)
// Admin routes (admin.localhost)
Route::domain('admin.localhost')->group(function () {
    // Guest routes
    Route::middleware('guest')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])
            ->name('admin.register');  // Changed to admin.register for namespacing
        Route::post('register', [RegisteredUserController::class, 'store']);

        Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('admin.login');  // Changed to admin.login
        Route::post('login', [AuthenticatedSessionController::class, 'store']);
    });

    // Authenticated admin routes
    Route::middleware(['auth'])->group(function () {
        // Dashboard route - this will be the default redirect after login
        Route::get('/', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('admin.logout');  // Changed to admin.logout

        // Protected admin routes (requires admin role)
        Route::middleware([AdminMiddleware::class])->name('admin.')->group(function () {
            Route::resource('products', ProductController::class);
            Route::resource('categories', CategoryController::class);
            Route::resource('orders', OrderController::class);
            Route::resource('users', UserController::class);
            Route::get('/homepage', [HomepageController::class, 'admin'])->name('homepage');
            Route::post('/homepage', [HomepageController::class, 'store'])->name('homepage.store');
            Route::delete('/homepage/{id}', [HomepageController::class, 'destroy'])->name('homepage.destroy');


            //  product image async upload
            Route::post('/admin/products/images/upload', [ProductController::class, 'uploadImage'])->name('products.images.upload');

            // product image async delete
            Route::delete('/admin/products/images/{id}', [ProductController::class, 'destroyImage'])->name('products.images.destroy');
        });
    });
});

Route::post('set-locale', function (Request $request) {
    $locale = $request->locale;
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('set-locale');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
