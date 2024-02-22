<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Price\Read\Implementations;

use App\Models\BoxSize;
use Domain\Internal\Actions\Price\Read\GetBoxSizeContract;
use Domain\Internal\DataTransferObjects\Price\BoxSizeData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\QueryBuilder;

final class GetBoxSize implements GetBoxSizeContract
{
    /**
     * @return PaginationContract<BoxSizeData>
     */
    public function handle(PagingData $pagingData): PaginationContract
    {
        $query = BoxSize::query()
            // ->with(['prices', 'prices.priceItems'])
            ->orderBy('max_length')
            ->orderBy('max_width')
            ->orderBy('max_height')
            ->orderBy('max_weight');

        $boxSizePaginatedCollection = QueryBuilder::for(subject: $query)
            ->allowedFilters(
                filters: [
                    // AllowedFilter::scope('amount_between'),
                ]
            )
            ->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            );

        return $boxSizePaginatedCollection
            ->through(
                callback: fn (BoxSize $boxSize) => BoxSizeData::fromModel($boxSize)
            );
    }
}
