<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\CommodityDetailController;
use App\Http\Controllers\User\CommodityForecastController;
use App\Http\Controllers\User\RecommendationCenterController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\PredictionExplanationController;
use App\Http\Controllers\User\WatchlistController;
use App\Http\Controllers\PublicLandingController;
use App\Http\Controllers\PasswordRecoveryPreviewController;

Route::get('/', PublicLandingController::class)->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', LogoutController::class)->middleware('auth')->name('logout');

Route::get('/forgot-password', [PasswordRecoveryPreviewController::class, 'forgot'])->name('password.forgot');
Route::get('/verify-code', [PasswordRecoveryPreviewController::class, 'verify'])->name('password.verify');
Route::get('/reset-password', [PasswordRecoveryPreviewController::class, 'reset'])->name('password.reset');
Route::get('/password-updated', [PasswordRecoveryPreviewController::class, 'updated'])->name('password.updated');


Route::middleware(['auth', 'active', 'role:user'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('user.dashboard');
    Route::get('/komoditas/{code}', CommodityDetailController::class)->name('user.commodities.show');
    Route::get('/komoditas/{code}/prakiraan', CommodityForecastController::class)->name('user.commodities.forecast');
    Route::get('/rekomendasi', RecommendationCenterController::class)->name('user.recommendations.index');
    Route::get('/pengaturan', SettingsController::class)->name('user.settings.index');
    Route::put('/pengaturan/pantauan', [WatchlistController::class, 'update'])->name('user.settings.watchlist.update');
    Route::get('/profil', ProfileController::class)->name('user.profile.show');
    Route::get('/bantuan/prediksi/{code?}', PredictionExplanationController::class)->name('user.prediction.explanation');
});

require __DIR__.'/admin.php';

