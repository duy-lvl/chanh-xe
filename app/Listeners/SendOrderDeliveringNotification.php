<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderDelivering;
use App\Mail\OrderCheckpointReached;
use App\Models\Customer;
use Domain\CustomerFacing\Enums\OrderStatus;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Notifications\OrderDelivering as OrderDeliveringNotification;
use Throwable;
final class SendOrderDeliveringNotification
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
    public function handle(OrderDelivering $event): void
    {
        $order = $event->order;
        $location = $event->deliveringFromLocation;
        $time = $event->deliverTime;

        $sender = (object) [
            'name' => $order->sender_name,
            'email' => $order->sender_email,
        ];

        $receiver = (object) [
            'name' => $order->receiver_name,
            'email' => $order->receiver_email,
        ];

        foreach ([$sender, $receiver] as $i => $recipient) {
            try {
                Mail::to($recipient)->later(
                    delay: now()->addSeconds($i),
                    mailable: (new OrderCheckpointReached(
                        $order,
                        OrderStatus::Accepted,
                        $time,
                        $location
                    ))->afterCommit(),
                );
            }
            catch(Throwable $e){
                Log::error($e->getMessage());
            }
        }

        try {
            Customer::find($order->customer_id)?->notify(new OrderDeliveringNotification($order));
        } catch (Throwable $e) {
            Log::warning($e->getMessage());
        }
    }
}
