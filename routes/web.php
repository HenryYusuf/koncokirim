<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Restaurant;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'index'])->name('index');

Route::get('/dashboard', function () {
    return view('frontend.dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/profile-store', [UserController::class, 'profileStore'])->name('profile.store');

    Route::get('/change-password', [UserController::class, 'userChangePassword'])->name('change.password');
    Route::post('/change-password-update', [UserController::class, 'changePasswordUpdate'])->name('change.password.update');

    Route::get('/user-logout', [UserController::class, 'userLogout'])->name('user.logout');
});

require __DIR__ . '/auth.php';


Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'adminLogin'])->name('admin.login');
    Route::post('/login-submit', [AdminController::class, 'adminLoginSubmit'])->name('admin.login_submit');

    Route::get('/forget-password', [AdminController::class, 'adminForgetPassword'])->name('admin.forget_password');
    Route::post('/forget-password-submit', [AdminController::class, 'adminForgetPasswordSubmit'])->name('admin.forget_password_submit');

    Route::get('/reset-password/{token}/{email}', [AdminController::class, 'adminResetPassword']);
    Route::post('/reset-password-submit', [AdminController::class, 'adminResetPasswordSubmit'])->name('admin.reset_password_submit');

    Route::get('/logout', [AdminController::class, 'adminLogout'])->name('admin.logout');


    Route::middleware(Admin::class)->group(function () {
        Route::get('/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');

        Route::get('/profile', [AdminController::class, 'adminProfile'])->name('admin.profile');
        Route::post('/profile', [AdminController::class, 'adminProfileStore'])->name('admin.profile.store');

        Route::get('/change-password', [AdminController::class, 'adminChangePassword'])->name('admin.change.password');
        Route::post('/change-password-update', [AdminController::class, 'adminChangePasswordUpdate'])->name('admin.change.password.update');

        // All admin category controller
        Route::controller(CategoryController::class)->group(function () {
            Route::get('/all/category', 'adminAllCategory')->name('admin.all.category');
            Route::get('/add/category', 'adminAddCategory')->name('admin.add.category');
            Route::post('/add/category-store', 'adminAddCategoryStore')->name('admin.category.store');
            Route::get('/edit/category/{category}', 'adminEditCategory')->name('admin.edit.category');
            Route::post('/edit/category-update', 'adminEditCategoryUpdate')->name('admin.category.update');
            Route::get('/delete/category/{category}', 'adminDeleteCategoryUpdate')->name('admin.delete.category');
        });

        // All admin city controller
        Route::controller(CityController::class)->group(function () {
            Route::get('/all/city', 'adminAllCity')->name('admin.all.city');
            Route::post('/add/city-store', 'adminAddCityStore')->name('admin.city.store');
            Route::get('/edit/city/{city}', 'adminEditCity')->name('admin.edit.city');
            Route::post('/edit/city-update', 'adminEditCityUpdate')->name('admin.city.update');
            Route::get('/delete/city/{city}', 'adminDeleteCityUpdate')->name('admin.delete.city');
        });
    });
});



Route::get('/restaurant/login', [RestaurantController::class, 'restaurantLogin'])->name('restaurant.login');
Route::post('/restaurant/login-submit', [RestaurantController::class, 'restaurantLoginSubmit'])->name('restaurant.login_submit');

Route::get('/restaurant/register', [RestaurantController::class, 'restaurantRegister'])->name('restaurant.register');
Route::post('/restaurant/register-submit', [RestaurantController::class, 'restaurantRegisterSubmit'])->name('restaurant.register_submit');

// Route::get('/admin/forget-password', [AdminController::class, 'adminForgetPassword'])->name('admin.forget_password');
// Route::post('/admin/forget-password-submit', [AdminController::class, 'adminForgetPasswordSubmit'])->name('admin.forget_password_submit');

// Route::get('/admin/reset-password/{tokem}/{email}', [AdminController::class, 'adminResetPassword']);
// Route::post('/admin/reset-password-submit', [AdminController::class, 'adminResetPasswordSubmit'])->name('admin.reset_password_submit');

Route::get('/restaurant/logout', [RestaurantController::class, 'restaurantLogout'])->name('restaurant.logout');


Route::middleware(Restaurant::class)->group(function () {
    Route::get('/restaurant/dashboard', [RestaurantController::class, 'restaurantDashboard'])->name('restaurant.dashboard');

    Route::get('/restaurant/profile', [RestaurantController::class, 'restaurantProfile'])->name('restaurant.profile');
    Route::post('/restaurant/profile', [RestaurantController::class, 'restaurantProfileStore'])->name('restaurant.profile.store');

    Route::get('/restaurant/change-password', [RestaurantController::class, 'restaurantChangePassword'])->name('restaurant.change.password');
    Route::post('/restaurant/change-password-update', [RestaurantController::class, 'restaurantChangePasswordUpdate'])->name('restaurant.change.password.update');
});
