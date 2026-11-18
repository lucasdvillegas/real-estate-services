<?php

use App\Http\Controllers\OperationTypeController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyFeatureController;
use App\Http\Controllers\PropertyStatusController;
use App\Http\Controllers\PropertyTypeController;
use App\Http\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');

    Route::prefix('properties')->group(function () {
        Route::post('upload-images', [PropertyController::class, 'uploadImages'])->name('properties.images.upload');
    });

    // Property resources
    Route::resource('propertyTypes', PropertyTypeController::class);
    Route::resource('propertyFeatures', PropertyFeatureController::class);
    Route::resource('operationTypes', OperationTypeController::class);
    Route::resource('properties', PropertyController::class);
    Route::resource('propertyStatuses', PropertyStatusController::class);
});

require __DIR__.'/settings.php';
