<?php

declare(strict_types=1);

namespace Domain\Partner\Actions\Station\Read\Implementations;

use App\Models\Station;
use Domain\Partner\Actions\Station\Read\GetStationContract;
use Domain\Partner\DataTransferObjects\Station\StationData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Illuminate\Database\Eloquent\Builder;
use Facades\Domain\Shared\Services\Image;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;


final class GetStation implements GetStationContract
{
    public function handle(?int $partnerId = null, PagingData $pagingData): PaginationContract
    {
        $query = Station::query()->when($partnerId, function (Builder $query, int $partnerId): void {
            $query->with('partner')->where('partner_id', $partnerId);
        })->orderByDesc('partner_stations.created_at');

        return QueryBuilder::for(
            subject: $query
        )
            ->allowedFilters(
                filters: ['name', 'address', AllowedFilter::exact('status')]
            )->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            )->through(
                function (Station $model): StationData{
                    $avatarUrl = Image::getFileTemporaryUrl($model->partner->avatar_url);
                    return StationData::fromModel($model, $avatarUrl);
                }
            );
    }
}
