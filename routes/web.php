<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// 1. BASIC ROUTES
// Route::get('/basic', fn () => 'GET request');
// Route::post('/basic', fn () => 'POST request');
// Route::put('/basic', fn () => 'PUT request');
// Route::patch('/basic', fn () => 'PATCH request');
// Route::delete('/basic', fn () => 'DELETE request');


// =============================================
// Route publik (tanpa login)
// =============================================
Route::get('/', function () {
    return view('welcome');
});

// =============================================
// Route Dashboard - bisa diakses oleh user yang memiliki permission 'view-dashboard'
// =============================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'permission:view-dashboard'])->name('dashboard');

// =============================================
// Route Admin - hanya bisa diakses Admin
// =============================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Role management
    Route::resource('roles', RoleController::class)->except(['show']);

    // Halaman daftar user
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    // Halaman edit user
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

    // Update data user
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    // Delete data user
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

});

// =============================================
// Route Profile (dari Breeze)
// =============================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// 2. ROUTE PARAMETERS
Route::get('/users/{id}', function (int $id) {
    return "User ID: {$id}";
});

Route::get('/users/{id}/posts/{postId?}', function (
    int $id,
    ?int $postId = null
) {
    if ($postId) {
        return "Post #{$postId} milik User #{$id}";
    }

    return "Semua post milik User #{$id}";
});

// 4. RESOURCE ROUTES
Route::resource('products', ProductController::class);

Route::resource('categories', CategoryController::class);

Route::resource('orders', OrderController::class)
    ->except(['create', 'edit']);

// 5. NESTED RESOURCE
Route::resource(
    'categories.products',
    CategoryProductController::class
)->only(['index', 'create', 'store']);

// 6. REDIRECT & FALLBACK
Route::redirect('/old-url', '/new-url', 301);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::fallback(function () {
    abort(404);
});

// Cara 1: Middleware di route langsung
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
