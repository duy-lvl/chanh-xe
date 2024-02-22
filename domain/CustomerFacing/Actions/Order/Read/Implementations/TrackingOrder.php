<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Read\Implementations;

use App\Models\Order;
use App\Models\OrderRouteCheckpoint;
use App\Models\OrderRoutePermission;
use Domain\CustomerFacing\Actions\Order\Read\TrackingOrderContract;
use Domain\CustomerFacing\DataTransferObjects\Order\CheckpointData;
use Domain\CustomerFacing\DataTransferObjects\Order\OrderTrackingData;
use Domain\CustomerFacing\DataTransferObjects\Order\PermissionData;
use Domain\CustomerFacing\Enums\PaymentMethod;
use Illuminate\Support\Str;

final class TrackingOrder implements TrackingOrderContract
{
    public function handle(string $code, bool $onlyAchievedFlag = true): ?OrderTrackingData
    {
        $orderModel = Order::query()
            ->with(['routeCheckpoints.permissions', 'routeCheckpoints.checkpoint'])
            ->where('code', Str::lower($code))->first();

        if (null === $orderModel) {
            return null;
        }

        
        $checkpoints = $orderModel->routeCheckpoints
            ->sortBy('checkpoint_number')->values()
            ->map(function (OrderRouteCheckpoint $orderRouteCheckpoint) {
                $permissions = $orderRouteCheckpoint->permissions->sortBy('permission_number')->values()->map(fn (OrderRoutePermission $permission) => PermissionData::fromModel($permission));
                return CheckpointData::fromModel($orderRouteCheckpoint->checkpoint, $permissions);
            }
        );
        $canBepaid = ! ($orderModel->isPaid || $orderModel->payment_method === PaymentMethod::Cash || !$orderModel->is_confirmed || $orderModel->is_cancelled);
        $canBeCancelled = !$orderModel->isPaid && !$orderModel->is_confirmed && !$orderModel->is_cancelled;
        return new OrderTrackingData(
            checkpoints: $checkpoints, 
            createdAt: $orderModel->created_at?->toImmutable(), 
            isCancelled: (bool)$orderModel->is_cancelled,
            cancelledAt: $orderModel->cancelled_at?->toImmutable(),
            canBeCancelled: $canBeCancelled,
            confirmedAt: $orderModel->confirmed_at?->toImmutable(),
            canBePaid: $canBepaid
        );

    }
}
