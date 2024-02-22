<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderRouteCheckpoint;
use App\Models\OrderRoutePermission;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PruneUnusedOrders implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $userCancelledOrders = Order::query()
            ->where('is_cancelled', true)
            ->where('is_lost', false)
            ->whereDoesntHave('payments')
            ->get();

        $unconfirmedOrders = Order::query()
            ->where('created_at', '<=', Carbon::now()->subDays(3))
            ->where('is_confirmed', false)
            ->get();

        $ordersToBeDeleted = $userCancelledOrders->merge($unconfirmedOrders)->unique();

        $ordersToBeDeleted->load('routeCheckpoints.permissions');

        $orderIds = $ordersToBeDeleted->pluck('id');
        $checkpointsIds = $ordersToBeDeleted->pluck('routeCheckpoints')->collapse()->pluck('id');
        $permissionIds = $ordersToBeDeleted->pluck('routeCheckpoints')->collapse()->pluck('permissions')->collapse()->pluck('id');

        OrderRoutePermission::destroy($permissionIds);
        OrderRouteCheckpoint::destroy($checkpointsIds);
        Order::destroy($orderIds);
    }
}
