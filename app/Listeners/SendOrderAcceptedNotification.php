<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderAccepted;
use App\Mail\OrderCheckpointReached;
use App\Models\Customer;
use App\Models\Order;
use DateTimeImmutable;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\Shared\DataTransferObjects\LocationData;
use Exception;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Notifications\OrderAccepted as OrderAcceptedNotification;
use Throwable;
final class SendOrderAcceptedNotification
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
    public function handle(OrderAccepted $event): void
    {
        $order = $event->order;
        $location = $event->acceptedLocation;
        $time = $event->acceptedTime;

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
                    ))->afterCommit()
                );
            }
            catch(Throwable $e){
                Log::error($e->getMessage());
            }
        }

        try {
            Customer::find($order->customer_id)?->notify(new OrderAcceptedNotification($order));
        } catch (Throwable $e) {
            Log::warning($e->getMessage());
        }
    }
}
