<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::get('/admin/login', [AdminController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin/login-submit', [AdminController::class, 'adminLoginSubmit'])->name('admin.login_submit');

Route::get('/admin/forget-password', [AdminController::class, 'adminForgetPassword'])->name('admin.forget_password');
Route::post('/admin/forget-password-submit', [AdminController::class, 'adminForgetPasswordSubmit'])->name('admin.forget_password_submit');

Route::get('/admin/reset-password/{tokem}/{email}', [AdminController::class, 'adminResetPassword']);
Route::post('/admin/reset-password-submit', [AdminController::class, 'adminResetPasswordSubmit'])->name('admin.reset_password_submit');

Route::get('/admin/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');

Route::middleware(Admin::class)->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');

    Route::get('/admin/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
    Route::post('/admin/profile', [AdminController::class, 'adminProfileStore'])->name('admin.profile.store');


    Route::get('/admin/change-password', [AdminController::class, 'adminChangePassword'])->name('admin.change.password');
    Route::post('/admin/change-password-update', [AdminController::class, 'adminChangePasswordUpdate'])->name('admin.change.password.update');
});
