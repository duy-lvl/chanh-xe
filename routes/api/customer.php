<?php

declare(strict_types=1);

use App\Http\Api\Controllers\CustomerFacing\Auth\GetAccessToken;
use App\Http\Api\Controllers\CustomerFacing\Auth\RegisterNewCustomerAccount;
use App\Http\Api\Controllers\CustomerFacing\Auth\UpdatePassword;
use App\Http\Api\Controllers\CustomerFacing\Notification\GetNotification;
use App\Http\Api\Controllers\CustomerFacing\Order\CancelOrder;
use App\Http\Api\Controllers\CustomerFacing\Order\CreateOrder;
use App\Http\Api\Controllers\CustomerFacing\Order\GetCustomerOrderHistory;
use App\Http\Api\Controllers\CustomerFacing\Order\GetOrderPayments;
use App\Http\Api\Controllers\CustomerFacing\Order\GetOrderPaymentStatus;
use App\Http\Api\Controllers\CustomerFacing\Order\SearchRouteForOrder;
use App\Http\Api\Controllers\CustomerFacing\Order\TrackingOrder;
use App\Http\Api\Controllers\CustomerFacing\Order\UpdateOrder;
use App\Http\Api\Controllers\CustomerFacing\Order\ViewOrderDetail;
use App\Http\Api\Controllers\CustomerFacing\Partner\GetPartner;
use App\Http\Api\Controllers\CustomerFacing\Partner\GetPartnerDetail;
use App\Http\Api\Controllers\CustomerFacing\Payment\GetPayment;
use App\Http\Api\Controllers\CustomerFacing\Payment\GetPaymentUrl;
use App\Http\Api\Controllers\CustomerFacing\Payment\ProceedPayment;
use App\Http\Api\Controllers\CustomerFacing\Price\GetPackagePrice;
use App\Http\Api\Controllers\CustomerFacing\Profile\GetSelfProfile;
use App\Http\Api\Controllers\CustomerFacing\Profile\UpdateProfile;
use Illuminate\Support\Facades\Route;

Route::name('customer.')->prefix('customer')->group(function (): void {
    //public
    Route::middleware('guest')->group(function (): void {
        //auth
        Route::post('/register', RegisterNewCustomerAccount::class)->name('register');
        Route::post('/login/token', GetAccessToken::class)->name('auth.token');

        //order
        Route::get('route/search', SearchRouteForOrder::class);
        Route::post('orders', CreateOrder::class)->name('order.create');
        Route::get('orders/{code}/tracking', TrackingOrder::class)->name('order.tracking');
        Route::put('orders/{code}/cancelled', CancelOrder::class)->name('orders.cancelled');
        // Route::get('orders/{id}', ViewOrderDetail::class)->name('order.detail');
        Route::get('orders/{code}/payment-status', GetOrderPaymentStatus::class)->name('order.payment-status');

        //price
        // Route::get('/box-sizes', GetBoxSize::class);
        Route::get('/package-price', GetPackagePrice::class);

        //payment
        Route::get('/orders/{code}/payments/vnpay/url', GetPaymentUrl::class);
        Route::get('/payments/vnpay/webhook', ProceedPayment::class);

        //partner
        Route::get('/partners', GetPartner::class);
        Route::get('/partners/{id}', GetPartnerDetail::class);
    });

    //authenticated
    Route::middleware('auth:api_customer')->group(function (): void {
        //auth
        Route::put('/auth/password', UpdatePassword::class)->name('password.update');

        //profile
        Route::get('/profile/me', GetSelfProfile::class)->name('profile.get');
        Route::put('/profile/me', UpdateProfile::class)->name('profile.update');

        //order
        Route::get('orders', GetCustomerOrderHistory::class)->name('order.all');
        Route::get('orders/{code}', ViewOrderDetail::class)->name('order.detail');
        Route::get('orders/{code}/payments', GetOrderPayments::class)->name('order.payments');
        Route::put('orders/{code}', UpdateOrder::class)->name('order.update');
        
        //payment
        Route::get('payments', GetPayment::class)->name('payment.get');

        //notification
        Route::get('notifications', GetNotification::class)->name('notification.get');
    });
});
