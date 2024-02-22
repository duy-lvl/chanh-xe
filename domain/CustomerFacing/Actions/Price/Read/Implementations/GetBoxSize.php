<?php

declare(strict_types=1);

namespace Domain\CustomerFacing\Actions\Price\Read\Implementations;

use App\Models\BoxSize;
use Domain\CustomerFacing\Actions\Price\Read\GetBoxSizeContract;
use Domain\CustomerFacing\DataTransferObjects\Price\BoxSizeData;
use Domain\CustomerFacing\DataTransferObjects\Price\PriceItemData;
use Domain\CustomerFacing\Enums\PriceStatus;
use Illuminate\Support\Collection;

final class GetBoxSize implements GetBoxSizeContract
{
    public function handle(): Collection
    {
        $boxSizes = BoxSize::query()
            ->orderBy('max_length', 'asc')
            ->orderBy('max_width', 'asc')
            ->orderBy('max_height', 'asc')
            ->orderBy('max_weight', 'asc')
            ->get();

        $boxSizeData = collect();
        foreach ($boxSizes as $boxSize) {

            $price = $boxSize->prices()
                ->where([
                    ['apply_from', '<=', now()],
                    ['apply_to', '>=', now()],
                    ['status', PriceStatus::Active],
                ])
                ->orderByDesc('priority')
                ->first();

            $priceItems = $price->priceItems()->get();

            $priceItemData = collect();
            foreach ($priceItems as $priceItem) {
                $priceItemData->add(PriceItemData::fromModel($priceItem));
            }

            $boxSizeData->add(BoxSizeData::fromModel($boxSize, $priceItemData));
        }

        return $boxSizeData;
    }
}
