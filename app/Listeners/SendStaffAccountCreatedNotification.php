<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\StaffAccountCreated;
use App\Mail\StaffAccountCreated as StaffAccountCreatedMail;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

final class SendStaffAccountCreatedNotification
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
    public function handle(StaffAccountCreated $event): void
    {
        $accountData = $event->accountData;

        try {
            Mail::to((object) [
                'name' => $accountData->username,
                'email' => $accountData->email,
            ])->send(
                (new StaffAccountCreatedMail($accountData))->afterCommit()
            );
        } catch (Exception $e) {
            Log::warning($e->getMessage());
        }
    }
}
