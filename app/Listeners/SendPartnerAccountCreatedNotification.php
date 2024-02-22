<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\PartnerAccountCreated;
use Illuminate\Support\Facades\Mail;

final class SendPartnerAccountCreatedNotification
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
    public function handle(PartnerAccountCreated $event): void
    {
        // $accountData = $event->accountData;

        // try {
        //     Mail::to((object) [
        //         'name' => $order->sender_name,
        //         'email' => $accountData->name->sender_email,
        //     ])->send(
        //         (new OrderDoneMail(
        //             $order,
        //             $time,
        //             $location
        //         ))->afterCommit()
        //     );
        // } catch (Exception $e) {
        //     Log::warning($e->getMessage());
        // }
    }
}
