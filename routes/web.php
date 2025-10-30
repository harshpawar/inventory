<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ManufactureController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('inventory-items', InventoryItemController::class);
    Route::post('inventory-items/{inventoryItem}/adjust', [InventoryItemController::class, 'adjust'])->name('inventory-items.adjust');

    Route::resource('products', ProductController::class);

    Route::get('manufactures', [ManufactureController::class, 'index'])->name('manufactures.index');
    Route::get('manufactures/create', [ManufactureController::class, 'create'])->name('manufactures.create');
    Route::post('manufactures', [ManufactureController::class, 'store'])->name('manufactures.store');

    Route::get('reports/manufactured', [ReportController::class, 'manufactured'])->name('reports.manufactured');
    Route::get('reports/inventory-usage', [ReportController::class, 'inventoryUsage'])->name('reports.inventoryUsage');
    Route::get('reports/inventory-movements', [ReportController::class, 'inventoryMovements'])->name('reports.inventoryMovements');
});

require __DIR__.'/auth.php';
