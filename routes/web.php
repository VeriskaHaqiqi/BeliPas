<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\CommodityDetailController;
use App\Http\Controllers\User\CommodityForecastController;
use App\Http\Controllers\User\RecommendationCenterController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\User\ProfileController;

Route::redirect('/', '/login');

Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');
// Development preview only; protect this route with the agreed auth middleware before production.
Route::get('/dashboard', DashboardController::class)->name('user.dashboard');
Route::get('/komoditas/{code}', CommodityDetailController::class)->name('user.commodities.show');
Route::get('/komoditas/{code}/prakiraan', CommodityForecastController::class)->name('user.commodities.forecast');
Route::get('/rekomendasi', RecommendationCenterController::class)->name('user.recommendations.index');
Route::get('/pengaturan', SettingsController::class)->name('user.settings.index');
Route::get('/profil', ProfileController::class)->name('user.profile.show');
