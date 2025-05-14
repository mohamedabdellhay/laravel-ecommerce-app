<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // ... other admin routes ...

    // Products CRUD
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);

    // ... other admin routes ...
});
