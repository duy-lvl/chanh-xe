<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\Partner\Notification;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\Partner\Notification\GetNotificationRequest;
use App\Http\Api\Responses\Partner\Notification\NotificationResource;
use Domain\Partner\Actions\Notification\Read\GetNotificationContract;
use Illuminate\Support\Facades\Auth;

/**
 * @group Partner 
 *
 * APIs for Partner app
 *
 * @subgroup Notification
 *
 * @subgroupDescription Partner Notification
 */
final class GetNotification extends Controller
{
    public function __construct(
        private readonly GetNotificationContract $getNotificationAction
    ) {
    }

    /**
     * Get Notifications - Handle an incoming get Notifications request from Partner.
     */
    public function __invoke(GetNotificationRequest $request): mixed
    {
        $pagingData = $request->getPagingData();
        $Notifications = $this->getNotificationAction->handle(Auth::id(), $pagingData);

        return NotificationResource::collection($Notifications);
    }
}
