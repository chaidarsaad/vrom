<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\DetailController;
use App\Http\Controllers\Front\LandingController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\API\MidtransCallbackController;
use App\Http\Controllers\Front\BenefitController;
use App\Http\Controllers\Front\CatalogController;

Route::name('front.')->group(function () {
    Route::post('midtrans/callback', [MidtransCallbackController::class, 'callback']);

    Route::get('/', [LandingController::class, 'index'])->name('index');
    Route::get('/detail/{slug}', [DetailController::class, 'index'])->name('detail');

    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');
    Route::get('/catalog/brand/{slug}', [CatalogController::class, 'detail'])->name('catalog.detail');

    Route::get('/benefit', [BenefitController::class, 'index'])->name('benefit');

    // Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/checkout/{slug}', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout/{slug}', [CheckoutController::class, 'store'])->name('checkout.store');

        Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
        Route::get('/payment/{bookingId}', [PaymentController::class, 'index'])->name('payment');
        Route::post('/payment/{bookingId}', [PaymentController::class, 'update'])->name('payment.update');

        Route::get('/mydashboard', [DashboardController::class, 'index'])->name('mydashboard');
        Route::get('/mydashboard/detail/{orderId}', [DashboardController::class, 'detail'])->name('mydashboard.detail');
    });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
