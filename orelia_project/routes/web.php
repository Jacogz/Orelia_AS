<?php

use App\Http\Controllers\Admin\AdminCollectionController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminMaterialController;
use App\Http\Controllers\Admin\AdminPieceController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CollectionController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\MaterialController;
use App\Http\Controllers\User\PieceController;
use Illuminate\Support\Facades\Route;

Auth::routes();

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// User Routes
Route::get('/pieces', [PieceController::class, 'index'])->name('pieces.index');
Route::get('/pieces/{id}', [PieceController::class, 'show'])->name('pieces.show');
Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
Route::get('/collections', [CollectionController::class, 'index'])->name('collections.index');
Route::get('/collections/{id}', [CollectionController::class, 'show'])->name('collections.show');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Admin Routes
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Admin pieces management routes
        Route::get('/pieces', [AdminPieceController::class, 'index'])->name('pieces.index');
        Route::get('/pieces/create', [AdminPieceController::class, 'create'])->name('pieces.create');
        Route::post('/pieces', [AdminPieceController::class, 'store'])->name('pieces.store');
        Route::get('/pieces/{id}/edit', [AdminPieceController::class, 'edit'])->name('pieces.edit');
        Route::put('/pieces/{id}', [AdminPieceController::class, 'update'])->name('pieces.update');
        Route::delete('/pieces/{id}', [AdminPieceController::class, 'destroy'])->name('pieces.destroy');

        // Admin materials management routes
        Route::get('/materials', [AdminMaterialController::class, 'index'])->name('materials.index');
        Route::get('/materials/create', [AdminMaterialController::class, 'create'])->name('materials.create');
        Route::post('/materials', [AdminMaterialController::class, 'store'])->name('materials.store');
        Route::get('/materials/{id}/edit', [AdminMaterialController::class, 'edit'])->name('materials.edit');
        Route::put('/materials/{id}', [AdminMaterialController::class, 'update'])->name('materials.update');
        Route::delete('/materials/{id}', [AdminMaterialController::class, 'destroy'])->name('materials.destroy');

        // Admin collections management routes
        Route::get('/collections', [AdminCollectionController::class, 'index'])->name('collections.index');
        Route::get('/collections/create', [AdminCollectionController::class, 'create'])->name('collections.create');
        Route::post('/collections', [AdminCollectionController::class, 'store'])->name('collections.store');
        Route::get('/collections/{id}/edit', [AdminCollectionController::class, 'edit'])->name('collections.edit');
        Route::put('/collections/{id}', [AdminCollectionController::class, 'update'])->name('collections.update');
        Route::delete('/collections/{id}', [AdminCollectionController::class, 'destroy'])->name('collections.destroy');
    });
