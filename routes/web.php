<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $commerces = \App\Models\Commerce::all();
    return view('dashboard', compact('commerces'));
})->middleware(['auth', 'verified'])->name('dashboard');

// User routes (browsing)
Route::get('/c', [\App\Http\Controllers\CommerceController::class, 'index'])->name('commerce.index');
Route::get('/c/{commerce}', [\App\Http\Controllers\CommerceController::class, 'show'])->name('commerce.show');

Route::middleware(['auth', 'verified', 'role:commerce'])->group(function () {
    Route::get('/commerce/dashboard', function () {
        return view('commerce.dashboard');
    })->name('commerce.dashboard');
    Route::get('/commerce/profile', [\App\Http\Controllers\CommerceController::class, 'edit'])->name('commerce.profile.edit');
    Route::put('/commerce/profile', [\App\Http\Controllers\CommerceController::class, 'update'])->name('commerce.profile.update');
    Route::resource('products', \App\Http\Controllers\ProductController::class);
});

Route::middleware(['auth', 'verified', 'role:courier'])->group(function () {
    Route::get('/courier/dashboard', function () {
        return view('courier.dashboard');
    })->name('courier.dashboard');
    Route::get('/courier/available', [\App\Http\Controllers\CourierController::class, 'available'])->name('courier.available');
    Route::post('/courier/deliveries/{delivery}/accept', [\App\Http\Controllers\CourierController::class, 'accept'])->name('courier.accept');
    Route::post('/courier/deliveries/{delivery}/complete', [\App\Http\Controllers\CourierController::class, 'complete'])->name('courier.complete');
    Route::get('/courier/my-deliveries', [\App\Http\Controllers\CourierController::class, 'myDeliveries'])->name('courier.my');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Orders Route (common for tracking)
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/cart', [\App\Http\Controllers\OrderController::class, 'viewCart'])->name('orders.cart');
    Route::post('/cart/add/{product}', [\App\Http\Controllers\OrderController::class, 'addToCart'])->name('orders.add');
    Route::post('/checkout/{order}', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('orders.checkout');
});

Route::middleware(['auth', 'verified', 'role:commerce'])->group(function () {
    // ... products routes ...
    Route::get('/commerce/orders', [\App\Http\Controllers\OrderController::class, 'commerceOrders'])->name('commerce.orders');
    Route::put('/commerce/orders/{order}/status', [\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('commerce.orders.status');
});

// ── PayU ──────────────────────────────────────────
Route::get('/checkout-test', [PaymentController::class, 'preparePayment']);
Route::post('/payu/webhook', [PaymentController::class, 'webhook']);

require __DIR__.'/auth.php';
