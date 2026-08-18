<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AboutController;
use App\Http\Controllers\Public\FoundItemController;
use App\Http\Controllers\Public\SearchController;
use App\Http\Controllers\Public\LostReportController;
use App\Http\Controllers\Public\ClaimController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FoundItemController as AdminFoundItemController;
use App\Http\Controllers\Admin\LostReportController as AdminLostReportController;
use App\Http\Controllers\Admin\ClaimController as AdminClaimController;
use App\Http\Controllers\Admin\ReturnReportController as AdminReturnReportController;
use App\Http\Controllers\Admin\AiMatchingController as AdminAiMatchingController;
use App\Http\Controllers\Admin\AiAutoDescController as AdminAiAutoDescController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;

/*
|--------------------------------------------------------------------------
| Public Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about');

Route::get('/found-items', [FoundItemController::class, 'index'])->name('found-items');
Route::get('/found-items/{id}', [FoundItemController::class, 'show'])->name('item-detail');

Route::get('/search', SearchController::class)->name('search');

Route::get('/report-lost', [LostReportController::class, 'create'])->name('lost-report');
Route::post('/report-lost', [LostReportController::class, 'store'])->name('lost-report.store');

Route::get('/claim/{id?}', [ClaimController::class, 'create'])->name('claim');
Route::post('/claim/{id?}', [ClaimController::class, 'store'])->name('claim.store');

Route::get('/contact', ContactController::class)->name('contact');

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin', fn() => redirect()->route('login'));

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('login'));
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Found Item Management
    Route::get('/found-items', [AdminFoundItemController::class, 'index'])->name('found-items.index');
    Route::post('/found-items', [AdminFoundItemController::class, 'store'])->name('found-items.store');
    Route::put('/found-items/{id}', [AdminFoundItemController::class, 'update'])->name('found-items.update');
    Route::delete('/found-items/{id}', [AdminFoundItemController::class, 'destroy'])->name('found-items.destroy');

    // Lost Report Management
    Route::get('/lost-reports', [AdminLostReportController::class, 'index'])->name('lost-reports.index');
    Route::get('/lost-reports/{id}', [AdminLostReportController::class, 'show'])->name('lost-reports.show');
    Route::put('/lost-reports/{id}/status', [AdminLostReportController::class, 'updateStatus'])->name('lost-reports.update-status');

    // Claim Management
    Route::get('/claims', [AdminClaimController::class, 'index'])->name('claims.index');
    Route::post('/claims/{id}/approve', [AdminClaimController::class, 'approve'])->name('claims.approve');
    Route::post('/claims/{id}/reject', [AdminClaimController::class, 'reject'])->name('claims.reject');

    // Berita Acara / Return Report
    Route::get('/return-report', [AdminReturnReportController::class, 'index'])->name('return-report.index');
    Route::get('/return-report/{id}/print', [AdminReturnReportController::class, 'print'])->name('return-report.print');

    // AI Features
    Route::get('/ai-matching', [AdminAiMatchingController::class, 'index'])->name('ai-matching.index');
    Route::post('/ai-matching/scan', [AdminAiMatchingController::class, 'match'])->name('ai-matching.scan');

    Route::get('/ai-auto-desc', [AdminAiAutoDescController::class, 'index'])->name('ai-auto-desc.index');
    Route::post('/ai-auto-desc/generate', [AdminAiAutoDescController::class, 'generate'])->name('ai-auto-desc.generate');

    // Category Management
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    // User Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Analytics
    Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/analytics/export', [AdminAnalyticsController::class, 'export'])->name('analytics.export');

    // Profile & Settings
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    Route::get('/settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');
});
