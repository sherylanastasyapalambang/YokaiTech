<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Buyer;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('admin/users', UserController::class)->names([
        'index' => 'dashboard.admin.users.index',
        // 'create' => 'dashboard.admin.users.create',
        // 'store' => 'dashboard.admin.users.store',
        'show' => 'dashboard.admin.users.show',
        'edit' => 'dashboard.admin.users.edit',
        'update' => 'dashboard.admin.users.update',
        'destroy' => 'dashboard.admin.users.destroy',
    ]);
    
    Route::resource('admin/products', ProductController::class)->names([
        'index' => 'dashboard.admin.products.index',
        // 'create' => 'dashboard.admin.products.create',
        // 'store' => 'dashboard.admin.products.store',
        'show' => 'dashboard.admin.products.show',
        // 'edit' => 'dashboard.admin.products.edit',
        // 'update' => 'dashboard.admin.products.update',
        'destroy' => 'dashboard.admin.products.destroy',
    ]);


    Route::resource('admin/categories', CategoryController::class)->names([
        'index' => 'dashboard.admin.categories.index',
        'create' => 'dashboard.admin.categories.create',
        'store' => 'dashboard.admin.categories.store',
        'show' => 'dashboard.admin.categories.show',
        'edit' => 'dashboard.admin.categories.edit',
        'update' => 'dashboard.admin.categories.update',
        'destroy' => 'dashboard.admin.categories.destroy',
    ]);

    Route::resource('admin/stores', StoreController::class)->names([
        'index' => 'dashboard.admin.stores.index',
        // 'create' => 'dashboard.admin.stores.create',
        // 'store' => 'dashboard.admin.stores.store',
        'show' => 'dashboard.admin.stores.show',
        // 'edit' => 'dashboard.admin.stores.edit',
        // 'update' => 'dashboard.admin.stores.update',
        // 'destroy' => 'dashboard.admin.stores.destroy',
    ]);

    Route::resource('admin/reviews', ReviewController::class)->names([
        'index' => 'dashboard.admin.reviews.index',
        // 'create' => 'dashboard.admin.reviews.create',
        // 'store' => 'dashboard.admin.reviews.store',
        'show' => 'dashboard.admin.reviews.show',
        // 'edit' => 'dashboard.admin.reviews.edit',
        // 'update' => 'dashboard.admin.reviews.update',
        'destroy' => 'dashboard.admin.reviews.destroy',
    ]);
});


Route::middleware(['auth', 'seller'])->group(function () {
    Route::resource('seller/products', ProductController::class)->names([
        'index' => 'dashboard.seller.products.index',
        'create' => 'dashboard.seller.products.create',
        'store' => 'dashboard.seller.products.store',
        'show' => 'dashboard.seller.products.show',
        'edit' => 'dashboard.seller.products.edit',
        'update' => 'dashboard.seller.products.update',
        'destroy' => 'dashboard.seller.products.destroy',
    ]);

    Route::resource('seller/stores', StoreController::class)->names([
        'index' => 'dashboard.seller.stores.index',
        'create' => 'dashboard.seller.stores.create',
        'store' => 'dashboard.seller.stores.store',
        'show' => 'dashboard.seller.stores.show',
        'edit' => 'dashboard.seller.stores.edit',
        'update' => 'dashboard.seller.stores.update',
        'destroy' => 'dashboard.seller.stores.destroy',
    ]);

    Route::resource('seller/reviews', ReviewController::class)->names([
        'index' => 'dashboard.seller.reviews.index',
        'create' => 'dashboard.seller.reviews.create',
        'store' => 'dashboard.seller.reviews.store',
        'show' => 'dashboard.seller.reviews.show',
        // 'edit' => 'dashboard.seller.reviews.edit',
        // 'update' => 'dashboard.seller.reviews.update',
        // 'destroy' => 'dashboard.seller.reviews.destroy',
    ]);

    Route::resource('seller/orders', OrderController::class)->names([
        'index' => 'dashboard.seller.orders.index',
        // 'create' => 'dashboard.seller.orders.create',
        // 'store' => 'dashboard.seller.orders.store',
        'show' => 'dashboard.seller.orders.show',
        'edit' => 'dashboard.seller.orders.edit',
        'update' => 'dashboard.seller.orders.update',
        'destroy' => 'dashboard.seller.orders.destroy',
    ]);
    
    Route::resource('seller/orderItems', OrderItemController::class)->names([
        'index' => 'dashboard.seller.orderItems.index',
        // 'create' => 'dashboard.seller.orderItems.create',
        // 'store' => 'dashboard.seller.orderItems.store',
        'show' => 'dashboard.seller.orderItems.show',
        'edit' => 'dashboard.seller.orderItems.edit',
        'update' => 'dashboard.seller.orderItems.update',
        'destroy' => 'dashboard.seller.orderItems.destroy',
    ]);

    Route::resource('seller/user', UserController::class)->names([
        'show' => 'dashboard.seller.user.show',
        'edit' => 'dashboard.seller.user.edit',
        'update' => 'dashboard.seller.user.update',
    ]);

    Route::put('seller/orders/{id}/update-status', [OrderController::class, 'updateStatus'])
        ->name('dashboard.seller.orders.updateStatus');
});

Route::middleware(['auth', Buyer::class])->group(function () { 
    Route::resource('buyer/carts', CartController::class)->names([
        'index' => 'dashboard.buyer.carts.index',
        'create' => 'dashboard.buyer.carts.create',
        'store' => 'dashboard.buyer.carts.store',
        'show' => 'dashboard.buyer.carts.show',
        'edit' => 'dashboard.buyer.carts.edit',
        'update' => 'dashboard.buyer.carts.update',
        'destroy' => 'dashboard.buyer.carts.destroy',
    ]);

    Route::resource('buyer/cartItems', CartItemController::class)->names([
        'index' => 'dashboard.buyer.cartItems.index',
        'create' => 'dashboard.buyer.cartItems.create',
        'store' => 'dashboard.buyer.cartItems.store',
        'show' => 'dashboard.buyer.cartItems.show',
        'edit' => 'dashboard.buyer.cartItems.edit',
        'update' => 'dashboard.buyer.cartItems.update',
        'destroy' => 'dashboard.buyer.cartItems.destroy',
    ]);

    Route::resource('buyer/orders', OrderController::class)->names([
        'index' => 'dashboard.buyer.orders.index',
        'create' => 'dashboard.buyer.orders.create',
        'store' => 'dashboard.buyer.orders.store',
        'show' => 'dashboard.buyer.orders.show',
        'edit' => 'dashboard.buyer.orders.edit',
        'update' => 'dashboard.buyer.orders.update',
        'destroy' => 'dashboard.buyer.orders.destroy',
    ]);

    Route::resource('buyer/orderItems', OrderItemController::class)->names([
        'index' => 'dashboard.buyer.orderItems.index',
        'create' => 'dashboard.buyer.orderItems.create',
        'store' => 'dashboard.buyer.orderItems.store',
        'show' => 'dashboard.buyer.orderItems.show',
        'edit' => 'dashboard.buyer.orderItems.edit',
        'update' => 'dashboard.buyer.orderItems.update',
        'destroy' => 'dashboard.buyer.orderItems.destroy',
    ]);

    Route::resource('buyer/favorites', FavoriteController::class)->names([
        'index' => 'dashboard.buyer.favorites.index',
        'create' => 'dashboard.buyer.favorites.create',
        'store' => 'dashboard.buyer.favorites.store',
        'show' => 'dashboard.buyer.favorites.show',
        'edit' => 'dashboard.buyer.favorites.edit',
        'update' => 'dashboard.buyer.favorites.update',
        'destroy' => 'dashboard.buyer.favorites.destroy',
    ]);

    Route::resource('buyer/reviews', ReviewController::class)->names([
        'index' => 'dashboard.buyer.reviews.index',
        'create' => 'dashboard.buyer.reviews.create',
        'store' => 'dashboard.buyer.reviews.store',
        'show' => 'dashboard.buyer.reviews.show',
        // 'edit' => 'dashboard.buyer.reviews.edit',
        // 'update' => 'dashboard.buyer.reviews.update',
        // 'destroy' => 'dashboard.buyer.reviews.destroy',
    ]);

    Route::resource('buyer/user', UserController::class)->names([
        'show' => 'dashboard.buyer.user.show',
        'edit' => 'dashboard.buyer.user.edit',
        'update' => 'dashboard.buyer.user.update',
    ]);

    Route::resource('buyer/stores', StoreController::class)->names([
        'index' => 'dashboard.buyer.stores.index',
        'show' => 'dashboard.buyer.stores.show',
    ]);

    Route::post('buyer/cart-items/{cartItem}/increment', [CartItemController::class, 'increment'])->name('cartItems.increment');
    Route::post('buyer/cart-items/{cartItem}/decrement', [CartItemController::class, 'decrement'])->name('cartItems.decrement');
    Route::delete('buyer/cart-items/{cartItem}', [CartItemController::class, 'remove'])->name('cartItems.remove');
    Route::post('buyer/orders/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('dashboard.buyer.orders.cancel');

    // favorite
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/favorite/remove/{id}', [FavoriteController::class, 'destroy'])->name('favorites.remove');
});
