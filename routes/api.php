<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => response()->noContent());

// Auth
Route::post('/login', \App\Http\Controllers\Auth\LoginController::class)
    ->name('login');

// Users
Route::apiResource('users', \App\Http\Controllers\UserController::class)
    ->middleware(['auth:sanctum']);

Route::delete('/users', [\App\Http\Controllers\UserController::class, 'bulkDestroy'])
    ->name('users.bulk-destroy')
    ->middleware(['auth:sanctum']);

// Digital assets
Route::patch('/digital-assets', [\App\Http\Controllers\DigitalAssetController::class, 'bulkUpdate'])
    ->middleware(['auth:sanctum'])
    ->name('digital-assets.bulk-update');

Route::delete('/digital-assets', [\App\Http\Controllers\DigitalAssetController::class, 'bulkDestroy'])
    ->middleware(['auth:sanctum'])
    ->name('digital-assets.bulk-destroy');

Route::apiResource('digital-assets', \App\Http\Controllers\DigitalAssetController::class)
    ->middleware(['auth:sanctum']);

// Categories
Route::apiResource('categories', \App\Http\Controllers\CategoryController::class)
    ->middleware(['auth:sanctum']);

// Tags
Route::apiResource('tags', \App\Http\Controllers\TagController::class)
    ->middleware(['auth:sanctum']);

// Vouchers
Route::apiResource('vouchers', \App\Http\Controllers\VoucherController::class)
    ->middleware(['auth:sanctum']);

Route::delete('/vouchers', [\App\Http\Controllers\VoucherController::class, 'bulkDestroy'])
    ->name('vouchers.bulk-destroy')
    ->middleware(['auth:sanctum']);

// Dashboard
Route::get('/dashboard-data', \App\Http\Controllers\DashboardDataController::class)
    ->name('dashboard-data')
    ->middleware(['auth:sanctum']);

// Discounts
Route::apiResource('discounts', \App\Http\Controllers\DiscountController::class)
    ->middleware(['auth:sanctum']);

Route::delete('/discounts', [\App\Http\Controllers\DiscountController::class, 'bulkDestroy'])
    ->name('discounts.bulk-destroy')
    ->middleware(['auth:sanctum']);

// Rewards
Route::apiResource('rewards', \App\Http\Controllers\RewardController::class)
    ->middleware(['auth:sanctum']);

Route::delete('/rewards', [\App\Http\Controllers\RewardController::class, 'bulkDestroy'])
    ->name('rewards.bulk-destroy')
    ->middleware(['auth:sanctum']);
