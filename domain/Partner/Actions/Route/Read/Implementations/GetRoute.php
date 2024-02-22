<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Route\Read\Implementations;

use App\Models\Hub;
use App\Models\Route;
use App\Models\RouteMilestone;
use App\Models\RouteSegment;
use Domain\Partner\Actions\Route\Read\GetRouteContract;
use Domain\Partner\DataTransferObjects\Hub\HubData;
use Domain\Partner\DataTransferObjects\Route\RouteData;
use Domain\Partner\DataTransferObjects\RouteSegment\RouteMilestoneData;
use Domain\Partner\DataTransferObjects\RouteSegment\RouteSegmentData;
use Domain\Partner\DataTransferObjects\Station\StationData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

final class GetRoute implements GetRouteContract
{
    public function handle(?int $partnerId = null, PagingData $pagingData): PaginationContract
    {
        $query = Route::query()->when($partnerId, function (Builder $query, int $partnerId): void {
            $query->where('partner_id', $partnerId)->orderByDesc('created_at') ;
        })
            ->with(['milestones.station', 'milestones.hubs']);

        return QueryBuilder::for(
            subject: $query
        )
            ->allowedFilters(
                filters: [
                    'name',
                    AllowedFilter::exact('start_city_code'),
                    AllowedFilter::exact('start_district_code'),
                    AllowedFilter::exact('end_city_code'),
                    AllowedFilter::exact('end_district_code'),
                ]
            )->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            )
            ->through(
                function (Route $model): RouteData {

                    $milestoneData = $model->milestones->map(
                        fn (RouteMilestone $milestone) => RouteMilestoneData::fromModel(
                            $milestone,
                            StationData::fromModel($milestone->station),
                            $milestone->hubs->map(fn (Hub $hub) => HubData::fromModel($hub))
                        )
                    );

                    return RouteData::fromModel($model, $milestoneData);
                }
            );
    }
}
