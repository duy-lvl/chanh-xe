<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderCreated as OrderCreatedMail;
use App\Models\Customer;
use App\Models\Partner;
use App\Models\Station;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Notifications\OrderCreated as OrderCreatedNotification;
use Throwable;
final class SendOrderCreatedNotification
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
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        $time = $event->createdTime;
        $order->loadMissing('startStation.partner');

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
                    mailable:  (new OrderCreatedMail(
                        $order,
                        $time,
                    ))->afterCommit()
                );
            }
            catch(Throwable $e){
                Log::error($e->getMessage());
            }
        }

        try {
            $customer = Customer::find($order->customer_id);
            $customer?->notify(new OrderCreatedNotification($order));
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }

        try {
            $partner = Partner::find($order->startStation->partner_id);
            $partner?->notify(new OrderCreatedNotification($order));
        } catch (Throwable $e) {
            Log::error($e->getMessage());
        }
    }
}
