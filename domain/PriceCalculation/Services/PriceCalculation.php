<?php

declare(strict_types=1);

namespace Domain\PriceCalculation\Services;

use App\Models\BoxSize;
use App\Models\BoxSizePrice;
use Domain\Shared\Enums\LengthUnit;
use Domain\Shared\ValueObjects\Weight;
use Domain\Shared\ValueObjects\Distance;
use Illuminate\Database\Eloquent\Builder;
use Domain\Shared\ValueObjects\Dimensions;
use App\Exceptions\PriceCalculationException;
use Domain\Shared\Constants\DefaultConstant;

final class PriceCalculation
{
    public function calculateOrderPrice(Weight $weight, ?Dimensions $dimensions = null, Distance $distance, ?int $packageValue = 0): int
    {
        //determine the
        $boxSize = BoxSize::query()
            ->where('max_weight', '>=', $weight->value())
            ->when(null !== $dimensions, function (Builder $query) use ($dimensions): void {
                $query->where('max_width', '>=', $dimensions->width())
                    ->where('max_height', '>=', $dimensions->height())
                    ->where('max_length', '>=', $dimensions->length());
            })
            ->orderBy('max_weight', 'asc')
            ->orderBy('max_length', 'asc')
            ->orderBy('max_width', 'asc')
            ->orderBy('max_height', 'asc')
            ->first();

        if (null === $boxSize) {
            throw PriceCalculationException::UnavailableBoxSizeException();
        }

        //get current price table of highest priority
        $priceTable = $boxSize->prices()->valid()->orderByDesc('priority')->first();

        if (null === $priceTable) {
            throw PriceCalculationException::UnavailablePriceTableException();
        }

        //get price item based in Distance
        $priceItem = $priceTable->priceItems()
            ->where('from_kilometer', '<=', $distance->convertValue(LengthUnit::Kilometer))
            ->where('to_kilometer', '>=', $distance->convertValue(LengthUnit::Kilometer))
            ->select('price_per_kilometer', 'min_amount', 'max_amount')
            ->first();

        if (null === $priceItem) {
            throw PriceCalculationException::UnavailablePriceItemException();
        }

        //lost precision is +-1 kilometers, which is acceptable
        $tempCost = ((int) (round($distance->convertValue(LengthUnit::Kilometer))) * (int) $priceItem->price_per_kilometer);
        $finalCost = $tempCost;
        if ($tempCost < $priceItem->min_amount) {
            $finalCost = $priceItem->min_amount;
        } elseif ($tempCost > $priceItem->max_amount) {
            $finalCost = $priceItem->max_amount;
        }

        if ($packageValue >= DefaultConstant::PACKAGE_VALUE) {
            $finalCost += (int)round($packageValue * 0.005);
        }
        return (int) $finalCost; //we already round distance to int, and price_per_kilometer is also int in db, so $finalCost is always int
    }

    public function calculateMinPriceForDistance(Distance $distance): int
    {
        //get current price table of highest priority
        $priceTable = BoxSizePrice::query()->valid()->orderByDesc('priority')->first();

        if (null === $priceTable) {
            throw PriceCalculationException::UnavailablePriceTableException();
        }

        //get price item based in Distance
        $priceItem = $priceTable->priceItems()
            ->where('from_kilometer', '<=', $distance->convertValue(LengthUnit::Kilometer))
            ->where('to_kilometer', '>=', $distance->convertValue(LengthUnit::Kilometer))
            ->select('price_per_kilometer', 'min_amount', 'max_amount')
            ->first();

        if (null === $priceItem) {
            throw PriceCalculationException::UnavailablePriceItemException();
        }

        //lost precision is +-1 kilometers, which is acceptable
        $tempCost = ((int) (round($distance->convertValue(LengthUnit::Kilometer))) * (int) $priceItem->price_per_kilometer);
        $finalCost = $tempCost;
        if ($tempCost < $priceItem->min_amount) {
            $finalCost = $priceItem->min_amount;
        } elseif ($tempCost > $priceItem->max_amount) {
            $finalCost = $priceItem->max_amount;
        }
        
        return (int) $finalCost; //we already round distance to int, and price_per_kilometer is also int in db, so $finalCost is always int
    }
}
