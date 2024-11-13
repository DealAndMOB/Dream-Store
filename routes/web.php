<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\ShopController;

// Rutas de la tienda
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/search', [ShopController::class, 'search'])->name('shop.search');
Route::post('/cart/add/{product}', [ShopController::class, 'addToCart'])->name('shop.cart.add');
Route::post('/wishlist/add/{product}', [ShopController::class, 'addToWishlist'])->name('shop.wishlist.add');

// Rutas de administración
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('gestion-productos', [ProductManagementController::class, 'index'])->name('products.index');
    Route::post('gestion-productos/store', [ProductManagementController::class, 'store'])->name('products.store');
    Route::get('gestion-productos/show/{product}', [ProductManagementController::class, 'show'])->name('products.show');
    Route::post('gestion-productos/update/{product}', [ProductManagementController::class, 'update'])->name('products.update');
    Route::delete('gestion-productos/destroy/{product}', [ProductManagementController::class, 'destroy'])->name('products.destroy');
    Route::post('gestion-productos/update-stock/{product}', [ProductManagementController::class, 'updateStock'])->name('products.updateStock');
    Route::post('gestion-productos/toggle-status/{product}', [ProductManagementController::class, 'toggleStatus'])->name('products.toggleStatus');
});