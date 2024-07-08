<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Content\AboutusController;
use App\Http\Controllers\Content\BannerController;
use App\Http\Controllers\Content\SystemController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Post\CategoryController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Post\SubCategoryController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Middleware\adminMiddleware;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

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
        Route::post('/feature-create', [AboutusController::class, 'aboutusFeatureCreate'])->name('aboutus.feature.create');
        Route::post('/feature-data', [AboutusController::class, 'aboutusFeatureData'])->name('aboutus.feature.data');
        Route::post('/feature-data-delete', [AboutusController::class, 'featureDelete'])->name('feature.delete');
        Route::post('/feature-status', [AboutusController::class, 'featureStatus'])->name('feature.status');
        Route::post('/feature-edit', [AboutusController::class, 'featureEdit'])->name('feature.edit');
        Route::post('/feature-update', [AboutusController::class, 'featureUpdate'])->name('feature.update');
    });
    // about us-content route end

    // post menagement route start
    Route::prefix('post')->group(function () {
        Route::prefix('category')->group(function () {
            Route::get('/', [CategoryController::class, 'category'])->name('category');
            Route::post('/category-create', [CategoryController::class, 'categoryCreate'])->name('category.create');
            Route::post('/category-delete', [CategoryController::class, 'categoryDelete'])->name('category.delete');
            Route::post('/category-status', [CategoryController::class, 'categoryStatus'])->name('category.status');
            Route::post('/category-edit', [CategoryController::class, 'categoryEdit'])->name('category.edit');
            Route::post('/category-update', [CategoryController::class, 'categoryUpdate'])->name('category.update');
        });
        Route::prefix('sub-category')->group(function () {
            Route::get('/', [SubCategoryController::class, 'subcategory'])->name('subcategory');
            Route::post('/sub-category-create', [SubCategoryController::class, 'subcategoryCreate'])->name('subcategory.create');
            Route::post('/sub-category-delete', [SubCategoryController::class, 'subcategoryDelete'])->name('subcategory.delete');
            Route::post('/sub-category-status', [SubCategoryController::class, 'subcategoryStatus'])->name('subcategory.status');
            Route::post('/sub-category-edit', [SubCategoryController::class, 'subcategoryEdit'])->name('subcategory.edit');
            Route::post('/sub-category-update', [SubCategoryController::class, 'subcategoryUpdate'])->name('subcategory.update');
        });
        Route::prefix('/')->group(function () {
            Route::get('/', [PostController::class, 'postCreate'])->name('post.create');
            Route::post('/store', [PostController::class, 'postStore'])->name('post.store');
            Route::get('/list', [PostController::class, 'postList'])->name('post.list');
        });
    });
    // post menagement route end

    // role route start
    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'role'])->name('role');
    });
    // role route end
});

Route::get('/', [IndexController::class, 'index']);
