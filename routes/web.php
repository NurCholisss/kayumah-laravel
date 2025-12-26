<?php
// routes/web.php
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\OrderController as FrontOrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Tidak perlu login)
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Product Catalog
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES (Login & Register)
|--------------------------------------------------------------------------
*/

// Login Routes - hanya untuk guest (yang belum login)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');

    // Register Routes  
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// Logout Route - hanya untuk auth (yang sudah login)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Harus login sebagai user biasa)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Shopping Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Payment Routes (after order is created)
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}', [PaymentController::class, 'process'])->name('payment.process');
    Route::post('/payment/{order}/upload-proof', [PaymentController::class, 'uploadProof'])->name('payment.uploadProof');

    // Front - Order status (user)
    Route::get('/orders', [FrontOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [FrontOrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/invoice', [FrontOrderController::class, 'invoice'])->name('orders.invoice');
    Route::delete('/orders/{order}', [FrontOrderController::class, 'destroy'])->name('orders.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (Harus login DAN role admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products Management (CRUD)
    Route::resource('/products', AdminProductController::class);
    
    // Categories Management (CRUD tanpa show)
    Route::resource('/categories', CategoryController::class)->except(['show']);
    
    // Orders Management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{order}/approve-payment', [OrderController::class, 'approvePayment'])->name('orders.approvePayment');
    Route::post('/orders/{order}/mark-shipped', [OrderController::class, 'markShipped'])->name('orders.markShipped');
    
    // Users Management  
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
});

/*
|--------------------------------------------------------------------------
| FALLBACK ROUTE (Untuk handle 404 errors)
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return redirect()->route('home');
});