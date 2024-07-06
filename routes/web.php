<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Content\AboutusController;
use App\Http\Controllers\Content\BannerController;
use App\Http\Controllers\Content\SystemController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Middleware\adminMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/admincp', [AuthController::class, 'login'])->name('login');
Route::post('/loginPost', [AuthController::class, 'loginPost'])->name('loginPost');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['admin'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    // Other routes that require authentication

    //user managment start
    Route::get('/create-user', [AuthController::class, 'createUser'])->name('createUser');
    //user managment end

    // banner route start
    Route::prefix('banner')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('banner');
        Route::post('/create', [BannerController::class, 'bannerCreate'])->name('banner.create');
        Route::post('/delete', [BannerController::class, 'bannerDelete'])->name('banner.delete');
        Route::post('/status', [BannerController::class, 'bannerStatus'])->name('banner.status');
        Route::post('/edit', [BannerController::class, 'bannerEdit'])->name('banner.edit');
        Route::post('/update', [BannerController::class, 'bannerUpdate'])->name('banner.update');
    });
    // banner route end
    // content manegment route start
    Route::prefix('system-content')->group(function () {
        Route::get('/', [SystemController::class, 'index'])->name('system');
        Route::post('/systempost', [SystemController::class, 'systemPost'])->name('system.post');
    });
    // content manegment route end

    // about us-content route start
    Route::prefix('about-us')->group(function () {
        Route::get('/', [AboutusController::class, 'index'])->name('aboutus');
        Route::post('/create', [AboutusController::class, 'aboutusCreate'])->name('aboutus.create');
        Route::post('/content-edit', [AboutusController::class, 'aboutuscontentEdit'])->name('aboutuscontent.edit');
    });
    // about us-content route end

    // role route start
    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'role'])->name('role');
    });
    // role route end
});

Route::get('/', [IndexController::class, 'index']);
