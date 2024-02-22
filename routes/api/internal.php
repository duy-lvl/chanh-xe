<?php

declare(strict_types=1);

use App\Http\Api\Controllers\Internal\Account\CreatePartnerAccount;
use App\Http\Api\Controllers\Internal\Account\CreateStaffAccount;
use App\Http\Api\Controllers\Internal\Account\GetCustomerAccount;
use App\Http\Api\Controllers\Internal\Account\GetPartnerAccount;
use App\Http\Api\Controllers\Internal\Account\GetStaffAccount;
use App\Http\Api\Controllers\Internal\Account\UpdatePartnerAccountStatus;
use App\Http\Api\Controllers\Internal\Account\UpdateStaffAccountStatus;
use App\Http\Api\Controllers\Internal\Auth\GetAccessToken;
use App\Http\Api\Controllers\Internal\Auth\UpdatePassword;
use App\Http\Api\Controllers\Internal\Balance\GetCustomerDirectPaymentStatistics;
use App\Http\Api\Controllers\Internal\Balance\GetOrderRevenueStatistics;
use App\Http\Api\Controllers\Internal\Balance\GetPartnerAccountBalanceStatistics;
use App\Http\Api\Controllers\Internal\Balance\GetPartnerTopUpStatistics;
use App\Http\Api\Controllers\Internal\Balance\GetPartnerWithdrawStatistics;
use App\Http\Api\Controllers\Internal\Balance\GetPaymentList;
use App\Http\Api\Controllers\Internal\Balance\GetTransactionList;
use App\Http\Api\Controllers\Internal\Driver\GetDriver;
use App\Http\Api\Controllers\Internal\Hub\CreateHub;
use App\Http\Api\Controllers\Internal\Hub\GetHub;
use App\Http\Api\Controllers\Internal\Hub\GetHubById;
use App\Http\Api\Controllers\Internal\Order\CancelOrder;
use App\Http\Api\Controllers\Internal\Order\GetCancelledOrder;
use App\Http\Api\Controllers\Internal\Order\GetDoneOrder;
use App\Http\Api\Controllers\Internal\Order\GetOrder;
use App\Http\Api\Controllers\Internal\Order\StaffUpdateDeliveredStatus;
use App\Http\Api\Controllers\Internal\Order\StaffUpdateDeliveringStatus;
use App\Http\Api\Controllers\Internal\Price\CreateBoxSize;
use App\Http\Api\Controllers\Internal\Price\CreatePrice;
use App\Http\Api\Controllers\Internal\Price\GetBoxPrice;
use App\Http\Api\Controllers\Internal\Price\GetBoxSize;
use App\Http\Api\Controllers\Internal\Profile\GetSelfProfile;
use App\Http\Api\Controllers\Internal\Station\ApproveStation;
use App\Http\Api\Controllers\Internal\Station\DenyStation;
use App\Http\Api\Controllers\Internal\Station\GetStation;
use App\Http\Api\Controllers\Internal\Statistics\GetCustomer;
use App\Http\Api\Controllers\Internal\Statistics\GetLostOrder;
use App\Http\Api\Controllers\Internal\Statistics\GetMonthlyRevenue;
use App\Http\Api\Controllers\Internal\Statistics\GetMonthRevenue;
use App\Http\Api\Controllers\Internal\Statistics\GetOrderStatistics;
use App\Http\Api\Controllers\Internal\Statistics\GetPartner;
use App\Http\Api\Controllers\Internal\Statistics\GetTopCustomer;
use App\Http\Api\Controllers\Internal\Statistics\GetTopPartner;
use App\Http\Api\Controllers\Internal\Statistics\GetYearlyRevenueStatistics;
use App\Http\Api\Controllers\Internal\Transaction\GetTransactionRequestList;
use App\Http\Api\Controllers\Internal\Transaction\ProceedTopupTransaction;
use App\Http\Api\Controllers\Internal\Transaction\ProceedTransaction;
use App\Http\Api\Controllers\Internal\Transaction\ProceedWithdrawTransaction;
use App\Http\Api\Controllers\Internal\Vehicle\GetInComingVehicle;
use App\Http\Api\Controllers\Internal\Vehicle\GetVehicle;
use Illuminate\Support\Facades\Route;

Route::name('internal.')->prefix('internal')->group(function (): void {
    //public
    Route::middleware('guest')->group(function (): void {
        Route::post('/login/token', GetAccessToken::class)->name('auth.token');
    });

    //authenticated
    Route::middleware('auth:api_staff')->group(function (): void {
        //auth
        Route::put('/auth/password', UpdatePassword::class)->name('password.update');

        //transaction management
        Route::get('/transaction-requests', GetTransactionRequestList::class)->name('transaction.get');
        Route::post('/transaction-requests/top-up/{request_id}', ProceedTopupTransaction::class)->name('transaction.topup.proceed');
        Route::post('/transaction-requests/withdraw/{request_id}', ProceedWithdrawTransaction::class)->name('transaction.withdraw.proceed');

        //balance
        Route::get('/balance/transactions', GetTransactionList::class)->name('balance.transactions');
        Route::get('/balance/payments', GetPaymentList::class)->name('balance.payments');
        // Route::get('/payments', GetIncomesList::class)->name('balance.incomes');
        // Route::get('/payments', GetExpensesList::class)->name('balance.expenses');

        Route::get('/balance/partner-topup', GetPartnerTopUpStatistics::class)->name('balance.partner.topup');
        Route::get('/balance/partner-withdraw', GetPartnerWithdrawStatistics::class)->name('balance.partner.withdraw');
        Route::get('/balance/customer-direct-payment', GetCustomerDirectPaymentStatistics::class)->name('balance.customer.directPayment');
        Route::get('/balance/partner-account-balance', GetPartnerAccountBalanceStatistics::class)->name('balance.partner.accountBalance');
        Route::get('/balance/order-revenue', GetOrderRevenueStatistics::class)->name('balance.order.revenue');

        //account management
        Route::post('/account/partners', CreatePartnerAccount::class)->name('account.partner.create');
        Route::post('/account/staffs', CreateStaffAccount::class)->name('account.staff.create');
        Route::get('/account/staffs', GetStaffAccount::class)->name('account.staff.get');
        Route::get('/account/partners', GetPartnerAccount::class)->name('account.partner.get');
        Route::get('/account/customers', GetCustomerAccount::class)->name('account.customer.get');
        Route::put('/account/partners/{id}/status/{status}', UpdatePartnerAccountStatus::class)->name('account.partner.status');
        Route::put('/account/staffs/{id}/status/{status}', UpdateStaffAccountStatus::class)->name('account.staff.status');

        //price management
        Route::get('/tariff/box-sizes', GetBoxSize::class)->name('tariff.boxsize.get');
        Route::get('/tariff/box-sizes/{boxSizeId}/prices', GetBoxPrice::class)->name('tariff.boxsize.price.get');
        Route::post('/tariff/box-sizes/{boxSizeId}/prices', CreatePrice::class)->name('tariff.price.create');
        Route::post('/tariff/box-sizes', CreateBoxSize::class)->name('tariff.boxsize.create');

        //profile
        Route::get('/profile/me', GetSelfProfile::class)->name('profile');
        // Route::patch('/profile/me', UpdateSelfProfile::class)->name('profile.update');

        //order
        Route::put('/orders/{code}/status/delivered', StaffUpdateDeliveredStatus::class)->name('order.update.delivered');
        Route::put('/orders/{code}/status/delivering', StaffUpdateDeliveringStatus::class)->name('order.update.delivering');
        Route::get('/orders/done', GetDoneOrder::class)->name('order.done.get');
        Route::get('/orders/cancelled', GetCancelledOrder::class)->name('order.cancelled.get');
        Route::get('/orders', GetOrder::class)->name('order.get');
        Route::put('/orders/{code}/status/lost', CancelOrder::class)->name('order.update.lost');

        //station management
        Route::get('/stations', GetStation::class)->name('station.get');
        Route::put('/stations/{id}/approve', ApproveStation::class)->name('station.approve');
        Route::put('/stations/{id}/deny', DenyStation::class)->name('station.deny');

        //hub management
        Route::post('/hubs', CreateHub::class)->name('hub.create');
        Route::get('/hubs/{id}', GetHubById::class)->name('hub.getById');
        Route::get('/hubs', GetHub::class)->name('hub.get');

        //statistics
        Route::get('/statistics/top-customers/{numberOfCustomers}', GetTopCustomer::class)->name('statistics.top_customer');
        Route::get('/statistics/top-partners/{numberOfPartners}', GetTopPartner::class)->name('statistics.top_partner');
        Route::get('/statistics/orders', GetOrderStatistics::class)->name('statistics.order');
        Route::get('/statistics/orders/lost', GetLostOrder::class)->name('statistics.order.lost');
        Route::get('/statistics/orders/cancelled', GetLostOrder::class)->name('statistics.order.cancelled');
        Route::get('/statistics/customers', GetCustomer::class)->name('statistics.customers');
        Route::get('/statistics/partners', GetPartner::class)->name('statistics.partners');
        Route::get('/statistics/revenue/monthly', GetMonthlyRevenue::class)->name('statistics.monthly');
        Route::get('/statistics/revenue/month', GetMonthRevenue::class)->name('statistics.month');
        Route::get('/statistics/revenue/yearly', GetYearlyRevenueStatistics::class)->name('statistics.yearly');

        //driver
        Route::get('/partners/{id}/drivers', GetDriver::class)->name('drivers.get');

        //vehicle
        Route::get('/partners/{id}/vehicles', GetVehicle::class)->name('vehicles.get');
        Route::get('/vehicles/in-coming', GetInComingVehicle::class)->name('vehicles.in_coming.get');
    });
});
