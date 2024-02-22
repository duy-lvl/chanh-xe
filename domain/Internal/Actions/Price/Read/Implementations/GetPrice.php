<?php

declare(strict_types=1);

namespace Domain\Internal\Actions\Price\Read\Implementations;

use App\Models\BoxSizePrice;
use App\Models\PriceItem;
use Domain\Internal\Actions\Price\Read\GetPriceContract;
use Domain\Internal\DataTransferObjects\Price\BoxSizeData;
use Domain\Internal\DataTransferObjects\Price\PriceData;
use Domain\Internal\DataTransferObjects\Price\PriceItemData;
use Domain\Shared\DataTransferObjects\PagingData;
use Illuminate\Contracts\Pagination\Paginator as PaginationContract;
use Spatie\QueryBuilder\QueryBuilder;

final class GetPrice implements GetPriceContract
{
    /**
     * @return PaginationContract<BoxSizeData>
     */
    public function handle(int $boxSizeId, PagingData $pagingData): PaginationContract
    {
        $query = BoxSizePrice::query()
            ->where('box_size_id', $boxSizeId)
            ->with(['priceItems'])
            ->orderBy('created_at')
            ->orderBy('apply_from')
            ->orderBy('apply_to')
            ->orderBy('priority');

        $pricesPaginatedCollection = QueryBuilder::for(subject: $query)
            ->allowedFilters(
                filters: [
                    // AllowedFilter::scope('amount_between'),
                ]
            )
            ->fastPaginate(
                perPage: $pagingData->perPage,
                page: $pagingData->page,
            );

        return $pricesPaginatedCollection
            ->through(
                callback: function (BoxSizePrice $price) {
                    $items = collect($price->priceItems->map(
                        fn (PriceItem $item) => PriceItemData::fromModel($item)
                    ));

                    return PriceData::fromModel($price, $items);
                }
            );
    }
}
