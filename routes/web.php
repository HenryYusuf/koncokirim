<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ManageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Restaurant\CouponController;
use App\Http\Controllers\Restaurant\GalleryController;
use App\Http\Controllers\Restaurant\MenuController;
use App\Http\Controllers\Restaurant\ProductController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Restaurant;
use App\Http\Middleware\RestaurantStatus;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'index'])->name('index');

Route::get('/dashboard', function () {
    return view('frontend.dashboard.profile');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/profile-store', [UserController::class, 'profileStore'])->name('profile.store');

    Route::get('/change-password', [UserController::class, 'userChangePassword'])->name('change.password');
    Route::post('/change-password-update', [UserController::class, 'changePasswordUpdate'])->name('change.password.update');

    Route::get('/user-logout', [UserController::class, 'userLogout'])->name('user.logout');

    // Wishlist or Favourites
    Route::get('/dashboard/all/wishlist', [WishlistController::class, 'userAllWishlist'])->name('user.all.wishlist');
    Route::get('/dashboard/remove/wishlist/{wishlist}', [WishlistController::class, 'userRemoveWishlist'])->name('user.remove.wishlist');
});

require __DIR__ . '/auth.php';

Route::controller(HomeController::class)->group(function () {
    Route::get('/restaurant/details/{restaurant}', 'restaurantDetails')->name('user.restaurant.details');
    Route::post('/add-wish-list/{id}', 'addWishList');
});


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
            Route::get('/delete/category/{category}', 'adminDeleteCategory')->name('admin.delete.category');
        });

        // All admin city controller
        Route::controller(CityController::class)->group(function () {
            Route::get('/all/city', 'adminAllCity')->name('admin.all.city');
            Route::post('/add/city-store', 'adminAddCityStore')->name('admin.city.store');
            Route::get('/edit/city/{city}', 'adminEditCity')->name('admin.edit.city');
            Route::post('/edit/city-update', 'adminEditCityUpdate')->name('admin.city.update');
            Route::get('/delete/city/{city}', 'adminDeleteCity')->name('admin.delete.city');
        });

        // All admin manage controller
        Route::controller(ManageController::class)->group(function () {
            Route::get('/all/product', 'adminAllProduct')->name('admin.all.product');
            Route::get('/add/product', 'adminAddProduct')->name('admin.add.product');
            Route::post('/add/product-store', 'adminAddProductStore')->name('admin.product.store');
            Route::get('/edit/product/{product}', 'adminEditProduct')->name('admin.edit.product');
            Route::post('/edit/product-update', 'adminEditProductUpdate')->name('admin.product.update');
            Route::get('/delete/product/{product}', 'adminDeleteProduct')->name('admin.delete.product');
            Route::get('/change-status-product', 'adminChangeStatusProduct');

            Route::get('/pending/restaurant', 'adminAllPendingRestaurant')->name('admin.all.pending.restaurant');
            Route::get('/approve/restaurant', 'adminAllApproveRestaurant')->name('admin.all.approve.restaurant');
            Route::get('/change-status-restaurant', 'adminChangeStatusRestaurant');
        });

        // All admin banner controller
        Route::controller(BannerController::class)->group(function () {
            Route::get('/all/banner', 'adminAllBanner')->name('admin.all.banner');
            Route::post('/add/banner-store', 'adminAddBannerStore')->name('admin.banner.store');
            Route::get('/edit/banner/{banner}', 'adminEditBanner')->name('admin.edit.banner');
            Route::post('/edit/banner-update', 'adminEditBannerUpdate')->name('admin.banner.update');
            Route::get('/delete/banner/{banner}', 'adminDeleteBanner')->name('admin.delete.banner');
        });
    });
});


Route::prefix('restaurant')->group(function () {
    Route::get('/login', [RestaurantController::class, 'restaurantLogin'])->name('restaurant.login');
    Route::post('/login-submit', [RestaurantController::class, 'restaurantLoginSubmit'])->name('restaurant.login_submit');

    Route::get('/register', [RestaurantController::class, 'restaurantRegister'])->name('restaurant.register');
    Route::post('/register-submit', [RestaurantController::class, 'restaurantRegisterSubmit'])->name('restaurant.register_submit');

    // Route::get('/admin/forget-password', [AdminController::class, 'adminForgetPassword'])->name('admin.forget_password');
    // Route::post('/admin/forget-password-submit', [AdminController::class, 'adminForgetPasswordSubmit'])->name('admin.forget_password_submit');

    // Route::get('/admin/reset-password/{tokem}/{email}', [AdminController::class, 'adminResetPassword']);
    // Route::post('/admin/reset-password-submit', [AdminController::class, 'adminResetPasswordSubmit'])->name('admin.reset_password_submit');

    Route::get('/logout', [RestaurantController::class, 'restaurantLogout'])->name('restaurant.logout');

    Route::middleware(Restaurant::class)->group(function () {
        Route::get('/dashboard', [RestaurantController::class, 'restaurantDashboard'])->name('restaurant.dashboard');

        Route::get('/profile', [RestaurantController::class, 'restaurantProfile'])->name('restaurant.profile');
        Route::post('/profile', [RestaurantController::class, 'restaurantProfileStore'])->name('restaurant.profile.store');

        Route::get('/change-password', [RestaurantController::class, 'restaurantChangePassword'])->name('restaurant.change.password');
        Route::post('/change-password-update', [RestaurantController::class, 'restaurantChangePasswordUpdate'])->name('restaurant.change.password.update');

        Route::middleware(RestaurantStatus::class)->group(function () {
            // All restaurant menu controller
            Route::controller(MenuController::class)->group(function () {
                Route::get('/all/menu', 'restaurantAllMenu')->name('restaurant.all.menu');
                Route::get('/add/menu', 'restaurantAddMenu')->name('restaurant.add.menu');
                Route::post('/add/menu-store', 'restaurantAddMenuStore')->name('restaurant.menu.store');
                Route::get('/edit/menu/{menu}', 'restaurantEditMenu')->name('restaurant.edit.menu');
                Route::post('/edit/menu-update', 'restaurantEditMenuUpdate')->name('restaurant.menu.update');
                Route::get('/delete/menu/{menu}', 'restaurantDeleteMenu')->name('restaurant.delete.menu');
            });

            // All restaurant product controller
            Route::controller(ProductController::class)->group(function () {
                Route::get('/all/product', 'restaurantAllProduct')->name('restaurant.all.product');
                Route::get('/add/product', 'restaurantAddProduct')->name('restaurant.add.product');
                Route::post('/add/product-store', 'restaurantAddProductStore')->name('restaurant.product.store');
                Route::get('/edit/product/{product}', 'restaurantEditProduct')->name('restaurant.edit.product');
                Route::post('/edit/product-update', 'restaurantEditProductUpdate')->name('restaurant.product.update');
                Route::get('/delete/product/{product}', 'restaurantDeleteProduct')->name('restaurant.delete.product');

                Route::get('/change-status-product', 'restaurantChangeStatusProduct');
            });

            // All restaurant gallery controller
            Route::controller(GalleryController::class)->group(function () {
                Route::get('/all/gallery', 'restaurantAllGallery')->name('restaurant.all.gallery');
                Route::get('/add/gallery', 'restaurantAddGallery')->name('restaurant.add.gallery');
                Route::post('/add/gallery-store', 'restaurantAddGalleryStore')->name('restaurant.gallery.store');
                Route::get('/edit/gallery/{gallery}', 'restaurantEditGallery')->name('restaurant.edit.gallery');
                Route::post('/edit/gallery-update', 'restaurantEditGalleryUpdate')->name('restaurant.gallery.update');
                Route::get('/delete/gallery/{gallery}', 'restaurantDeleteGallery')->name('restaurant.delete.gallery');
            });

            // All restaurant coupon controller
            Route::controller(CouponController::class)->group(function () {
                Route::get('/all/coupon', 'restaurantAllCoupon')->name('restaurant.all.coupon');
                Route::get('/add/coupon', 'restaurantAddCoupon')->name('restaurant.add.coupon');
                Route::post('/add/coupon-store', 'restaurantAddCouponStore')->name('restaurant.coupon.store');
                Route::get('/edit/coupon/{coupon}', 'restaurantEditCoupon')->name('restaurant.edit.coupon');
                Route::post('/edit/coupon-update', 'restaurantEditCouponUpdate')->name('restaurant.coupon.update');
                Route::get('/delete/coupon/{coupon}', 'restaurantDeleteCoupon')->name('restaurant.delete.coupon');
            });
        });
    });
});
