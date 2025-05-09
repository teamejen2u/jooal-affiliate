<?php

// routes/web.php
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RewardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login/request-otp', [AuthController::class, 'requestOTP'])->name('login.requestOTP');
    Route::post('/login/verify-otp', [AuthController::class, 'verifyOTP'])->name('login.verifyOTP');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Missions
    Route::get('/missions', [MissionController::class, 'index'])->name('missions');
    Route::post('/missions/{mission}/claim', [MissionController::class, 'claimReward'])->name('missions.claim');
    
    // Rewards
    Route::get('/rewards', [RewardController::class, 'index'])->name('rewards');
    Route::post('/rewards/{reward}/redeem', [RewardController::class, 'redeem'])->name('rewards.redeem');
    
    // Brands
    Route::get('/brands', [BrandController::class, 'index'])->name('brands');
    Route::post('/brands/{brand}/generate-link', [BrandController::class, 'generateLink'])->name('brands.generateLink');
});

// Affiliate Link Redirect (public)
Route::get('/a/{linkCode}', [AffiliateController::class, 'redirect'])->name('affiliate.redirect');