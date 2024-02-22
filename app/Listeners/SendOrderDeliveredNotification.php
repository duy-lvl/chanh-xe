<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderDelivered;
use App\Mail\OrderCheckpointReached;
use App\Mail\OrderFinalCheckpointReached;
use App\Models\Customer;
use App\Models\Order;
use DateTimeImmutable;
use Domain\CustomerFacing\Enums\OrderStatus;
use Domain\Shared\DataTransferObjects\LocationData;
use Exception;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Notifications\OrderDelivered as OrderDeliveredNotification;
use Throwable;
final class SendOrderDeliveredNotification
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
    public function handle(OrderDelivered $event): void
    {
        $order = $event->order;
        $location = $event->deliveredLocation;
        $time = $event->deliveredTime;

        $order->loadMissing(['lastCheckpoint', 'currentCheckpoint']);

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
                    mailable: $this->getMail($order, $time, $location),
                );
            }
            catch(Throwable $e){
                Log::error($e->getMessage());
            }
        }

        try {
            Customer::find($order->customer_id)?->notify(new OrderDeliveredNotification($order));
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }
    }

    private function getMail(Order $order, DateTimeImmutable $time, LocationData $location): Mailable
    {
        $mail = ($order->lastCheckpoint->id !== $order->lastCheckpoint->id)
            ? new OrderCheckpointReached(
                $order,
                OrderStatus::Delivered,
                $time,
                $location
            )
            : new OrderFinalCheckpointReached(
                $order,
                OrderStatus::Delivered,
                $time,
                $location,
                $order->receive_token,
            );

        return $mail->afterCommit();
    }
}
