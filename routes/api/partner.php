<?php

declare(strict_types=1);

use App\Http\Api\Controllers\Partner\Statistics\DailyRevenue;
use App\Http\Api\Controllers\Partner\Auth\GetAccessToken;
use App\Http\Api\Controllers\Partner\Auth\UpdatePassword;
use App\Http\Api\Controllers\Partner\Driver\CreateDriver;
use App\Http\Api\Controllers\Partner\Driver\DeleteDriver;
use App\Http\Api\Controllers\Partner\Driver\GetDriver;
use App\Http\Api\Controllers\Partner\Driver\UpdateDriver;
use App\Http\Api\Controllers\Partner\Driver\UpdateDriverAvatar;
use App\Http\Api\Controllers\Partner\Hub\GetHub;
use App\Http\Api\Controllers\Partner\Notification\GetNotification;
use App\Http\Api\Controllers\Partner\Order\AcceptOrder;
use App\Http\Api\Controllers\Partner\Order\CancelOrder;
use App\Http\Api\Controllers\Partner\Order\ConfirmOrder;
use App\Http\Api\Controllers\Partner\Order\GetCancelledOrders;
use App\Http\Api\Controllers\Partner\Order\GetDoneOrders;
use App\Http\Api\Controllers\Partner\Order\GetEndingOrders;
use App\Http\Api\Controllers\Partner\Order\GetStartingOrders;
use App\Http\Api\Controllers\Partner\Order\GetStraightOrders;
use App\Http\Api\Controllers\Partner\Order\UpdateDeliveredStatus;
use App\Http\Api\Controllers\Partner\Order\UpdateDeliveringStatus;
use App\Http\Api\Controllers\Partner\Order\UpdateDoneStatus;
use App\Http\Api\Controllers\Partner\Profile\DeleteProfileAvatar;
use App\Http\Api\Controllers\Partner\Profile\GetSelfProfile;
use App\Http\Api\Controllers\Partner\Profile\UpdateProfile;
use App\Http\Api\Controllers\Partner\Profile\UpdateProfileAvatar;
use App\Http\Api\Controllers\Partner\Route\CreateRoute;
use App\Http\Api\Controllers\Partner\Route\GetRoute;
use App\Http\Api\Controllers\Partner\Station\CreateStation;
use App\Http\Api\Controllers\Partner\Station\GetStation;
use App\Http\Api\Controllers\Partner\Station\UpdateStation;
use App\Http\Api\Controllers\Partner\Statistics\MonthlyRevenue;
use App\Http\Api\Controllers\Partner\Transaction\CancelTransactionRequest;
use App\Http\Api\Controllers\Partner\Transaction\GetTransaction;
use App\Http\Api\Controllers\Partner\Transaction\GetTransactionRequest;
use App\Http\Api\Controllers\Partner\Transaction\TopupMoney;
use App\Http\Api\Controllers\Partner\Transaction\ViewBalance;
use App\Http\Api\Controllers\Partner\Transaction\WithdrawMoney;
use App\Http\Api\Controllers\Partner\Vehicle\CreateVehicle;
use App\Http\Api\Controllers\Partner\Vehicle\DeleteVehicle;
use App\Http\Api\Controllers\Partner\Vehicle\GetVehicle;
use App\Http\Api\Controllers\Partner\Vehicle\UpdateVehicle;
use App\Http\Api\Controllers\Partner\Vehicle\UpdateVehicleImage;
use Illuminate\Support\Facades\Route;

Route::name('partner.')->prefix('partner')->group(function (): void {
    //public
    Route::middleware('guest')->group(function (): void {
        //auth
        Route::post('/login/token', GetAccessToken::class)->name('auth.token');
    });

    //authenticated
    Route::middleware('auth:api_partner')->group(function (): void {
        //auth
        Route::put('/auth/password', UpdatePassword::class)->name('password.update');

        //profile
        Route::get('/profile/me', GetSelfProfile::class)->name('profile');
        Route::put('/profile/me', UpdateProfile::class)->name('profile.update');
        Route::put('/profile/me/avatar', UpdateProfileAvatar::class)->name('profile.avatar.update');
        Route::delete('/profile/me/avatar', DeleteProfileAvatar::class)->name('profile.avatar.delete');
        // Route::patch('/profile/me', UpdateSelfProfile::class)->name('profile.update');

        //station management
        Route::post('/stations', CreateStation::class)->name('station.create');
        Route::put('/stations/{id}', UpdateStation::class)->name('station.put');
        Route::get('/stations', GetStation::class)->name('station.get');

        //route managment
        Route::post('/routes', CreateRoute::class)->name('route.create');
        Route::get('/routes', GetRoute::class)->name('route.get');

        //hub
        Route::get('/hubs', GetHub::class)->name('hub');

        //transaction
        Route::get('/transactions', GetTransaction::class)->name('transaction_request');
        Route::get('/wallets/balance', ViewBalance::class)->name('balance');
        Route::delete('/transaction-requests/{id}', CancelTransactionRequest::class)->name('transaction_request.delete');
        Route::get('/transaction-requests', GetTransactionRequest::class)->name('transaction_request.get');
        Route::post('/transaction-requests/topup', TopupMoney::class)->name('transaction.topup');
        Route::post('/transaction-requests/withdraw', WithdrawMoney::class)->name('transaction.withdraw');

        //order
        Route::get('/orders/starting', GetStartingOrders::class)->name('orders.starting.get');
        Route::get('/orders/ending', GetEndingOrders::class)->name('orders.ending.get');
        Route::get('/orders/done', GetDoneOrders::class)->name('orders.done.get');
        Route::get('/orders/cancelled', GetCancelledOrders::class)->name('orders.cancelled.get');
        Route::get('/orders', GetStraightOrders::class)->name('orders.straight.get');
        Route::put('/orders/{code}/status/confirmed', ConfirmOrder::class)->name('orders.confirmed');
        Route::put('/orders/{code}/status/accepted', AcceptOrder::class)->name('orders.accepted');
        Route::put('/orders/{code}/status/delivering', UpdateDeliveringStatus::class)->name('orders.delivering');
        Route::put('/orders/{code}/status/delivered', UpdateDeliveredStatus::class)->name('orders.delivered');
        Route::put('/orders/{code}/status/done', UpdateDoneStatus::class)->name('orders.done');
        Route::put('/orders/{code}/status/lost', CancelOrder::class)->name('orders.lost');

        //statistics
        Route::get('/statistics/revenue/daily', DailyRevenue::class)->name('statistics.daily');
        Route::get('/statistics/revenue/monthly', MonthlyRevenue::class)->name('statistics.monthly');

        //driver
        Route::get('/drivers', GetDriver::class)->name('drivers.get');
        Route::put('/drivers/{id}', UpdateDriver::class)->name('drivers.update');
        Route::put('/drivers/{id}/avatar', UpdateDriverAvatar::class)->name('drivers.updateAvatar');
        Route::post('/drivers', CreateDriver::class)->name('drivers.create');
        Route::delete('/drivers/{id}', DeleteDriver::class)->name('drivers.delete');

        //vehicle
        Route::get('/vehicles', GetVehicle::class)->name('vehicles.get');
        Route::put('/vehicles/{id}', UpdateVehicle::class)->name('vehicles.update');
        Route::put('/vehicles/{id}/image', UpdateVehicleImage::class)->name('vehicles.updateImage');
        Route::post('/vehicles', CreateVehicle::class)->name('vehicles.create');
        Route::delete('/vehicles/{id}', DeleteVehicle::class)->name('vehicles.delete');

        //notification
        Route::get('notifications', GetNotification::class)->name('notification.get');
    });
});
