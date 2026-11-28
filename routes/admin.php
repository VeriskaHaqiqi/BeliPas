<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CommodityController;
use App\Http\Middleware\EnsureAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MarketController;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', EnsureAdmin::class])
    ->group(function () {

        Route::get('/', [
            DashboardController::class,
            'index'
        ])->name('dashboard');

        Route::get('/commodities', [
            CommodityController::class,
            'index'
        ])->name('commodities.index');

        Route::get('/commodities/create', [
            CommodityController::class,
            'create'
        ])->name('commodities.create');

        Route::post('/commodities', [
            CommodityController::class,
            'store'
        ])->name('commodities.store');

        Route::get('/commodities/{commodity}/edit', [
            CommodityController::class,
            'edit'
        ])->name('commodities.edit');

        Route::put('/commodities/{commodity}', [
            CommodityController::class,
            'update'
        ])->name('commodities.update');

        Route::patch('/commodities/{commodity}/status', [
            CommodityController::class,
            'toggleStatus'
        ])->name('commodities.toggle-status');

        Route::get('/markets', [
            MarketController::class, 'index'
        ])->name('markets.index');

        Route::get('/markets/create', [
            MarketController::class, 'create'
        ])->name('markets.create');

        Route::post('/markets', [
            MarketController::class, 'store'
        ])->name('markets.store');

        Route::get('/markets/{market}/edit', [
            MarketController::class, 'edit'
        ])->name('markets.edit');

        Route::put('/markets/{market}', [
            MarketController::class, 'update'
        ])->name('markets.update');

        Route::patch('/markets/{market}/status', [
            MarketController::class, 'toggleStatus'
        ])->name('markets.toggle-status');

    });
