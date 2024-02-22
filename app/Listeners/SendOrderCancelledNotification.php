<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderCancelled;
use App\Models\Customer;
use App\Notifications\OrderCancelled as OrderCancelledNotification;
use Exception;
use Illuminate\Support\Facades\Log;

final class SendOrderCancelledNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(OrderCancelled $event): void
    {
        $order = $event->order;

        try {
            Customer::find($order->customer_id)?->notify(new OrderCancelledNotification($order));
        } catch (Exception $e) {
            Log::warning($e->getMessage());
        }
    }
}
