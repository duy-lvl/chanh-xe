<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderDone;
use App\Mail\OrderDone as OrderDoneMail;
use App\Models\Customer;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Notifications\OrderDone as OrderDoneNotification;
use Throwable;
final class SendOrderDoneNotification
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
    public function handle(OrderDone $event): void
    {
        $order = $event->order;
        $location = $event->doneLocation;
        $time = $event->doneTime;

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
                    mailable: (new OrderDoneMail(
                        $order,
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
            Customer::find($order->customer_id)?->notify(new OrderDoneNotification($order));
        } catch (Throwable $e) {
            Log::warning($e->getMessage());
        }
    }
}
