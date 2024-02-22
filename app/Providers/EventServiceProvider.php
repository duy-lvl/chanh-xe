<?php

namespace App\Providers;

use App\Events\OrderAccepted;
use App\Events\OrderCreated;
use App\Events\OrderDelivered;
use App\Events\OrderDelivering;
use App\Events\OrderDone;
use App\Events\PartnerAccountCreated;
use App\Events\StaffAccountCreated;
use App\Listeners\ProcessTransactionForPartner;
use App\Listeners\SendOrderAcceptedNotification;
use App\Listeners\SendOrderCreatedNotification;
use App\Listeners\SendOrderDeliveredNotification;
use App\Listeners\SendOrderDeliveringNotification;
use App\Listeners\SendOrderDoneNotification;
use App\Listeners\SendPartnerAccountCreatedNotification;
use App\Listeners\SendStaffAccountCreatedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

final class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderCreated::class => [
            SendOrderCreatedNotification::class,
        ],
        OrderAccepted::class => [
            SendOrderAcceptedNotification::class,
        ],
        OrderDelivering::class => [
            SendOrderDeliveringNotification::class,
        ],
        OrderDelivered::class => [
            SendOrderDeliveredNotification::class,
            ProcessTransactionForPartner::class,
        ],
        OrderDone::class => [
            SendOrderDoneNotification::class,
        ],
        PartnerAccountCreated::class => [
            SendPartnerAccountCreatedNotification::class,
        ],
        StaffAccountCreated::class => [
            SendStaffAccountCreatedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
