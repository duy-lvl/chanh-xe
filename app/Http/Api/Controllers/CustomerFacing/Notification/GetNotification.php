<?php

declare(strict_types=1);

namespace App\Http\Api\Controllers\CustomerFacing\Notification;

use App\Http\Api\Controllers\Controller;
use App\Http\Api\Requests\CustomerFacing\Notification\GetNotificationRequest;
use App\Http\Api\Responses\CustomerFacing\Notification\NotificationResource;
use Domain\CustomerFacing\Actions\Notification\Read\GetNotificationContract;
use Illuminate\Support\Facades\Auth;

/**
 * @group Customer Facing
 *
 * APIs for customer app
 *
 * @subgroup Notification
 *
 * @subgroupDescription Customer Notification
 */
final class GetNotification extends Controller
{
    public function __construct(
        private readonly GetNotificationContract $getNotificationAction
    ) {
    }

    /**
     * Get Notifications - Handle an incoming get Notifications request from customer.
     */
    public function __invoke(GetNotificationRequest $request): mixed
    {
        $pagingData = $request->getPagingData();
        $Notifications = $this->getNotificationAction->handle(Auth::id(), $pagingData);

        return NotificationResource::collection($Notifications);
    }
}
