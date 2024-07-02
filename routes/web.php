<?php

use App\Http\Controllers\Auth\AuthController;
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
});