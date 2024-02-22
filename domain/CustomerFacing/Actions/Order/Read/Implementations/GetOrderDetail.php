<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Order\Read\Implementations;

use App\Models\Order;
use App\Models\OrderRouteCheckpoint;
use App\Models\OrderRoutePermission;
use App\Models\Payment;
use Domain\CustomerFacing\Actions\Order\Read\GetOrderDetailContract;
use Domain\CustomerFacing\DataTransferObjects\Order\CheckpointData;
use Domain\CustomerFacing\DataTransferObjects\Order\DetailedOrderData;
use Domain\CustomerFacing\DataTransferObjects\Order\PaymentData;
use Domain\CustomerFacing\DataTransferObjects\Order\PermissionData;
use Domain\CustomerFacing\DataTransferObjects\Order\StationData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

final class GetOrderDetail implements GetOrderDetailContract
{
    public function handle(string $code): ?DetailedOrderData
    {
        $order = Order::query()
            ->where('code', Str::lower($code))
            ->with(['routeCheckpoints.permissions', 'routeCheckpoints.checkpoint', 'startStation.partner.phones', 'endStation.partner.phones'])
            ->first();

        if (null === $order) {
            return null;
        }

        $payments = $order->payments->map(fn (Payment $model) => PaymentData::fromModel($model, $order->code));

        $checkpoints = $order->routeCheckpoints //->where('checkpoint_type', (new Hub())->getMorphClass())
            ->sortBy('checkpoint_number')->values()
            ->map(
                function (OrderRouteCheckpoint $orderRouteCheckpoint) {
                    $permissions = $orderRouteCheckpoint->permissions->sortBy('permission_number')->values()->map(fn (OrderRoutePermission $permission) => PermissionData::fromModel($permission));

                    return CheckpointData::fromModel($orderRouteCheckpoint->checkpoint, $permissions);
                }
            );

       

       

        return DetailedOrderData::fromModel(
            model: $order,
            checkpoints: $checkpoints,
            paymentData: $payments,
            startStation: StationData::fromModel($order->startStation, $order?->startStation?->partner?->phones?->pluck('phone')),
            endStation: StationData::fromModel($order->endStation, $order?->endStation?->partner?->phones?->pluck('phone')),
        );
    }
}
